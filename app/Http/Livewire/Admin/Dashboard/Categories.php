<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Category;
use App\Models\Worker;
use Livewire\Component;

class Categories extends Component
{
    //FOR ADD
    public $selectedCategoryId = '';
    public $selectedWorkerId = '';
    public $showAddCategory = false;

    //FOR SEARCH
    public $searchCategory = '';

    public function showAddCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;

        $selectedCategory = Category::find($this->selectedCategoryId);

        if (isset($selectedCategory)) {

            $this->emitUp('selectedCategory', [
                'id' => $this->selectedCategoryId
            ]);
        }

        $this->showAddCategory = false;
        $this->selectedCategoryId = '';
        $this->searchCategory = '';

    }


    public function render()
    {
        $this->categories = Category::select('id', 'name', 'image' , "description")
        ->search('name', $this->searchCategory)
        ->orderBy('created_at', 'asc')
        ->get();


        return view('livewire.admin.dashboard.categories', [
            'categories' => $this->categories,
        ]);

    }
}
