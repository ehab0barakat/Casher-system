<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use App\Traits\WithNotify;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use App\Models\OrderService;

class Dashboard extends Component
{
    use WithNotify;

    public $showFinish = false;
    public $PickProducts = false;

    public function finishOrder()
    {
        //CHECK IF CLIENT IS SELECTED
        // if (!isset($this->selectedClientId)) {
        //     $this->notify(true, __('messages.please-select-client'));
        //     return $this->showFinish = false;
        // }

        //CHECK IF THERE ARE PRODUCTS / SERVICES
        if (count($this->itemsList) == 0) {
            $this->notify(true, __('messages.items-List-empty'));
            return $this->showFinish = false;
        }

        //CHECK TOTALS
        if ($this->subtotal == 0 || $this->total == 0) {
            $this->notify(true, __('messages.total-not-valid'));
            return $this->showFinish = false;
        }

        //CHECK AVAILABLE QUANTITIES
        foreach ($this->itemsList as $key => $item) {
            //FOR PRODUCTS
            if (Str::contains($key, '0_')) {
                $result = Product::checkQuantityBeforeOrder($item['id'], $item['quantity']);

                if (isset($result)) {
                    $this->notify(true, __('messages.product-no-quantity', ['productName' => $result]));
                    return $this->showFinish = false;
                }
            }
        }

        //CREATING ORDER
        $order = Order::create(
            [
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'client_id' => $this->selectedClientId,
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'total' => $this->total,
            ]
        );

        //CREATE ITEMS IN ORDER
        foreach ($this->itemsList as $key => $item) {

            //IS PRODUCT
            // if (Str::contains($key, '0_')) {
            $product = Product::find($item['id']);
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->retailPrice,
                'total' => $product->retailPrice * $item['quantity'],
            ]);

            //UPDATE QUANTITY
            Product::updateQuantity($item['id'], $item['quantity']);
        }

        //OPEN RECEIPT PAGE
        $this->dispatchBrowserEvent('openReceipt', $order->id);

        //RESET ORDER
        $this->cancelOrder();
    }

    // FULL LIST
    public $itemsList = [];

    //SELECTED CLIENT
    public $selectedClientId = null;

    //SUMMARY
    public $subtotal = 0;

    public $total = 0;

    //FOR ITEMS
    // 0_id => PRODUCT
    // 1_id => SERVICE

    public function increaseQuantity($key)
    {
        if (array_key_exists($key, $this->itemsList)) {

            $this->itemsList[$key]['quantity']++;
            $this->subtotal += $this->itemsList[$key]['retailPrice'];
            $this->total = $this->subtotal - $this->discount;
        }
    }

    public function decreaseQuantity($key)
    {
        if (array_key_exists($key, $this->itemsList)) {

            if ($this->itemsList[$key]['quantity'] != 1) {
                $this->itemsList[$key]['quantity']--;
                $this->subtotal -= $this->itemsList[$key]['retailPrice'];
                $this->total = $this->subtotal - $this->discount;
            }
        }
    }

    public $showDeleteItem = false;
    public $selectedItemKey = null;

    public function showDeleteItem($key)
    {
        if (array_key_exists($key, $this->itemsList)) {

            $this->selectedItemKey = $key;
            $this->showDeleteItem = true;
        }
    }

    public function deleteItem()
    {
        $subtract = $this->itemsList[$this->selectedItemKey]['quantity'] * $this->itemsList[$this->selectedItemKey]['retailPrice'];

        $this->subtotal -= $subtract;
        $this->total -= $subtract;

        if ($this->total < $this->discount) {
            $this->total += $this->discount;
            $this->discount = 0;
        }

        unset($this->itemsList[$this->selectedItemKey]);

        $this->notify(false, 'messages.item-deleted');

        $this->showDeleteItem = false;
    }

    //FOR ORDER
    public $showCancel = false;

    public function cancelOrder()
    {
        $this->emit('reset');
        $this->reset();
    }

    //FOR DISCOUNT
    public $discount = 0;
    public $oldDiscount = 0;
    public $showDiscount = false;

    public function showDiscount()
    {
        $this->oldDiscount = $this->discount;
        $this->showDiscount = true;
    }

    public function saveDiscount()
    {
        $this->validate();

        $this->total += $this->oldDiscount;
        $this->total -= $this->discount;

        $this->notify(false, __('messages.discount-saved'));

        $this->showDiscount = false;
    }

    //LISTENERS
    protected $listeners = [
        'scan' => 'onScan',
        'selectedClient' => 'onClientSelected',
        'selectedCategory' => 'onCategorySelected',
        'productSelect' => 'onProductSelected',
        'ShowCategories' => 'onShowCategories',
    ];

    public $typedBarcodeId = '';

    public function addProductWithText()
    {
        if (empty($this->typedBarcodeId))
            return $this->notify(true, __('messages.barcode-id-not-found'));

        $scannedProduct = Product::where('barcodeId', '=', $this->typedBarcodeId)->first();

        if (!isset($scannedProduct))
            return $this->notify(true, __('messages.product-not-found'));

        if (array_key_exists('0_' . $scannedProduct->id, $this->itemsList)) {

            $this->itemsList['0_' . $scannedProduct->id]['quantity']++;
        } else {
            $this->itemsList['0_' . $scannedProduct->id] = [
                'id' => $scannedProduct->id,
                'name' => $scannedProduct->name,
                'retailPrice' => $scannedProduct->retailPrice,
                'retailPriceInCurrency' => $scannedProduct->retailPriceInCurrency,
                'quantity' => 1,
            ];
        }

        $this->subtotal += $scannedProduct->retailPrice;
        $this->total = $this->subtotal - $this->discount;
        $this->typedBarcodeId = '';
    }


    public function onScan($barCodeId)
    {
        if (empty($barCodeId))
            return $this->notify(true, __('messages.barcode-id-not-found'));

        $scannedProduct = Product::where('barcodeId', '=', $barCodeId)->first();

        if (!isset($scannedProduct))
            return $this->notify(true, __('messages.product-not-found'));

        if (array_key_exists('0_' . $scannedProduct->id, $this->itemsList)) {

            $this->itemsList['0_' . $scannedProduct->id]['quantity']++;
        } else {
            $this->itemsList['0_' . $scannedProduct->id] = [
                'id' => $scannedProduct->id,
                'name' => $scannedProduct->name,
                'retailPrice' => $scannedProduct->retailPrice,
                'retailPriceInCurrency' => $scannedProduct->retailPriceInCurrency,
                'quantity' => 1,
            ];
        }

        $this->subtotal += $scannedProduct->retailPrice;
        $this->total = $this->subtotal - $this->discount;
    }

    public function onClientSelected($clientId)
    {

        if (isset($clientId)) {

            $client = Client::find($clientId);

            if (!isset($client))
                return $this->notify(false, __('messages.client-not-found'));
        }

        $this->selectedClientId = $clientId;
    }

    public function onCategorySelected($category)
    {
        $this->PickProducts = true;
        $this->emit('ProductShow', ["id" => $category["id"]]);
    }

    public function onShowCategories()
    {
        $this->PickProducts = false;
    }


    public function onProductSelected($product)
    {
        if (isset($product['id'])) {

            $selectedProduct = Product::find($product['id']);

            if (!isset($selectedProduct))
                return $this->notify(true, __('messages.product-not-found'));

            if (array_key_exists('1_' . $selectedProduct->id, $this->itemsList)) {

                $this->itemsList['1_' . $selectedProduct->id]['quantity']++;
            } else {
                $this->itemsList['1_' . $selectedProduct->id] = [
                    'id' => $selectedProduct->id,
                    'name' => $selectedProduct->name,
                    'retailPrice' => $selectedProduct->costPrice,
                    'retailPriceInCurrency' => $selectedProduct->costPriceInCurrency,
                    'quantity' => 1,
                ];
            }

            $this->subtotal += $selectedProduct->costPrice;
            $this->total = $this->subtotal - $this->discount;
            return $this->notify(false, __('messages.item-added'));
        }
    }

    //COMPONENT
    public function rules()
    {
        return [
            'discount' => 'required|numeric|lt:' . $this->total,
        ];
    }

    public function validationRules()
    {
        return [
            'discount' => __('fields.discount'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'itemsList' => $this->itemsList,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total' => $this->total,
        ]);
    }
}
