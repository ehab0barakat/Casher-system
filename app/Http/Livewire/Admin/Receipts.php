<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderService;
use Livewire\Component;

class Receipts extends Component
{
    public $orderId = null ;

    public function mount($orderId)
    {
        $order = Order::find($orderId);

        if (!isset($order))
            abort(404);

        $this->orderId = $orderId;
    }
    public function render()
    {
        return view('livewire.admin.receipts', [
            'order' => Order::find($this->orderId),
            'products' => OrderProduct::whereOrderId($this->orderId)->get(),
        ])->layout('layouts.guest');
    }
}
