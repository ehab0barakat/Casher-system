<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Traits\WithNotify;
use App\Traits\WithSorting;
use Livewire\WithFileUploads;
use App\Traits\WithSimpleSearch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class Products extends Component
{
    use WithFileUploads;
    use WithSimpleSearch;
    use WithSorting;
    use WithNotify;

    // SCAN (optional)

    public $applyScanner = false;

    //FULL LIST
    public $products;
    public $suppliers;
    public $categories;

    //FOR RESTOCK
    public $showRestock = false;
    public $selectedProductId = '';
    public $restock = null;

    //FOR RESTOCK DIALOG
    public $showRestockModal = false;

    public function showRestockModal()
    {
        $this->resetValidation();
        $this->resetRestock();
        $this->showRestockModal = true;
    }

    public function updatedShowRestock()
    {
        $this->resetValidation();
        $this->showEdit = false;
    }

    public function saveRestock()
    {
        $this->validate([
            'selectedProductId' => 'required|in:' . $this->products->pluck('id')->implode(','),
            'restock' => 'required|numeric',
        ]);

        if (Product::updateStock($this->selectedProductId, $this->restock))
            $this->notify(false, __('messages.product-stock-updated'));

        $this->resetRestock();
        $this->showRestockModal = false;
    }

    public function resetRestock()
    {
        $this->selectedProductId = '';
        $this->restock = null;
    }

    //FOR SEARCH
    public $showSearch = false;

    public function updatedShowSearch()
    {

        if (!$this->showSearch)
            $this->searchQuery = null;
    }

    //FOR BOTH DIALOG AND NORMAL
    public Product $editing;
    public $photoUrl = null;
    public $photo = null;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {

        $this->editing = Product::make();
        $this->showEditModal = true;
    }

    public function showEditModal(Product $product)
    {
        $this->editing = $product;
        if (isset($this->editing->photo))
            $this->photoUrl = Storage::disk('products')->url($this->editing->photo);

        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Product $product)
    {
        $this->editing = $product;
        if (isset($this->editing->photo))
            $this->photoUrl = Storage::disk('products')->url($this->editing->photo);

        $this->resetValidation();
        $this->showRestock = false;
        $this->showEdit = true;
    }

    public function saveProduct()
    {

        $this->validate();
        if (isset($this->photo)) {

            if (isset($this->editing->photo))
                Storage::disk('products')->delete($this->editing->photo);

            $this->editing->photo = $this->photo->store('/', 'products');
        }

            if($this->barcodeId != null){
                $this->editing->barcodeId = $this->barcodeId;
            }

        if (($this->showEdit || $this->showEditModal)) {
            $this->editing->save();
            $this->notify(true, __('messages.product-saved'));
        } else {
            $this->editing->setBarcodeIdAndSave();
            $this->notify(true, __('messages.product-saved'));
        }


        $this->showEditModal = false;
        $this->resetProduct();
        $this->showEdit = false;
        $this->barcodeId = null ;
    }


    public function resetProduct()
    {
        $this->editing = Product::make([
            'supplier_id' => '',
            'category_id' => '',
        ]);

        $this->photo = null;
        $this->photoUrl = null;
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Product $deleting;

    public function showDelete(Product $product)
    {
        $this->deleting = $product;
        $this->showDelete = true;
    }

    public function deleteProduct()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.product-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        $rules = [
            'editing.name' => 'required|min:3',
            'editing.supplier_id' => 'required|in:' . $this->suppliers->pluck('id')->implode(','),
            'editing.quantity' => 'required|numeric|min:1|max:999',
            'editing.costPrice' => 'required|numeric|min:1|max:99999',
            'editing.retailPrice' => 'required|numeric|min:1|max:99999',
            'photo' => 'nullable|image|max:1024',
            'editing.category_id' => "required|exists:categories,id",
            'editing.barcodeId' => "nullable|unique:products,barcodeId," . $this->editing->id,
        ];

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'editing.supplier_id' => __('fields.supplier'),
            'editing.quantity' => __('fields.quantity'),
            'editing.costPrice' => __('fields.cost-price'),
            'editing.retailPrice' => __('fields.retail-price'),
            'editing.barcodeId' => __('fields.barcode'),
            'photo' => __('fields.photo'),
            'selectedProductId' => __('fields.product'),
            'restock' => __('fields.stock'),
        ];
    }

    public function mount()
    {
        $this->suppliers = Supplier::select('id', 'name', 'company')->get();
        $this->categories = Category::select('id', 'name')->where("status", "1")->get();
        $this->resetProduct();
    }

    //LISTENERS
    protected $listeners = [
        'add' => 'addNewProduct',
        'edit' => 'editStock',
    ];

    public function editStock($barCodeId)
    {
        if (empty($barCodeId))
            return $this->notify(false, __('messages.barcode-id-not-edit 1'));

        $scannedProduct = Product::where('barcodeId', '=', $barCodeId)->first();

        if (!isset($scannedProduct))
            return $this->notify(false, __('messages.product-id-not-edit 2'));

        $this->showRestock = true;

        $this->selectedProductId = $scannedProduct->id;
        $this->restock = $scannedProduct->quantity;
    }

    public $barcodeId;
    public function addNewProduct($barCodeId)
    {
        if (empty($barCodeId))
            return $this->notify(false, __('messages.barcode-id-not-add'));

        $this->showRestock = false;
        $this->showEdit = true;
        $scannedProduct = Product::where('barcodeId', '=', $barCodeId)->first();

        if (isset($scannedProduct))
            return $this->notify(false, __('messages.product-Exists'));

        $this->barcodeId = $barCodeId;
    }



    public function render()
    {
        $this->products = Product::select('id', 'name', 'supplier_id', 'category_id', 'quantity', 'retailPrice', 'costPrice', 'photo', 'created_at')
            ->whereStatus('1')
            ->search('name', $this->searchQuery)
            ->orderBy($this->field, $this->direction)
            ->get();

        return view('livewire.admin.products', [
            'products' => $this->products,
            'suppliers' => $this->suppliers,
            'categories' => $this->categories,
        ]);
    }
}
