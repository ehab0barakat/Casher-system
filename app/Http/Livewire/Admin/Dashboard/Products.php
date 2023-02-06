<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

class Products extends Component
{
    //FOR ADD
    public $selectedCategoryId = '';

    //FOR SEARCH
    public $searchProduct = '' ;


    protected $listeners = [
        'ProductShow' => 'onProductShow',
    ];

    public function ShowCategories()
    {
        $this->emitUp("ShowCategories");
    }

    public function onProductShow($category)
    {
        $this->selectedCategoryId = $category["id"];
    }

    public function AddProduct($product)
    {
        $this->emitUp("productSelect", ["id" => $product]);
    }

    public function render()
    {
        $this->products = Product::select('id', 'name', 'photo')
        ->search('name', $this->searchProduct)
        ->where("category_id" , $this->selectedCategoryId )
        ->orderBy('created_at', 'asc')
        ->get();


        return view('livewire.admin.dashboard.products', [
            'products' => $this->products,
        ]);
    }
}
