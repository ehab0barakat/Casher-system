<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Traits\WithNotify;
use App\Traits\WithSorting;
use Livewire\WithFileUploads;
use App\Traits\WithSimpleSearch;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;

class Categories extends Component
{

    use WithFileUploads;
    use WithSimpleSearch;
    use WithSorting;
    use WithNotify;

    //FOR SEARCH
    public $showSearch = false;

    public function updatedShowSearch()
    {

        if (!$this->showSearch)
            $this->searchQuery = null;
    }

    //FOR BOTH DIALOG AND NORMAL
    public Category $editing;
    public $image = null;
    public $imageUrl = null;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {

        $this->editing = Category::make();
        $this->showEditModal = true;
    }

    public function showEditModal(Category $category)
    {
        $this->editing = $category;
        if (isset($this->editing->image))
            $this->imageUrl = Storage::disk('categories')->url($this->editing->image);

        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Category $category)
    {
        $this->editing = $category;
        if (isset($this->editing->image))
            $this->imageUrl = Storage::disk('categories')->url($this->editing->image);

        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveCategory()
    {

        $this->validate();

        if (isset($this->image)) {

            if (isset($this->editing->image))
                Storage::disk('categories')->delete($this->editing->image);

            $this->editing->image = $this->image->store('/', 'categories');
        }

        if ($this->editing->save())
            $this->notify(false, __('messages.category-saved'));

        $this->showEditModal = false;
        $this->resetCategory();
        $this->showEdit = false;
    }

    public function resetCategory()
    {
        $this->editing = Category::make();
        $this->image = null;
        $this->imageUrl = null;
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Category $deleting;

    public function showDelete(Category $category)
    {
        $this->deleting = $category;
        $this->showDelete = true;
    }

    public function deleteCategory()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.category-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        return [
            'editing.name' => 'required|min:3|unique:categories,name,' . $this->editing->id,
            'image' => 'nullable|image|max:1024',
            'editing.description' => 'required|max:1024',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'image' => __('fields.image'),
            'description' => __('fields.description'),
        ];
    }

    public function mount()
    {

        $this->resetCategory();
    }

    public function render()
    {

        return view('livewire.admin.categories', [
            'categories' => Category::select('id', 'name', "status" , 'image', "description",  'created_at')

                ->whereStatus('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get()
        ]);
    }
}
