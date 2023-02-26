<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Supplier;
use App\Traits\WithNotify;
use App\Traits\WithSorting;
use Livewire\WithFileUploads;
use App\Traits\WithSimpleSearch;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;

class Suppliers extends Component
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
    public Supplier $editing;
    public $photo = null;
    public $photoUrl = null;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {

        $this->editing = Supplier::make();
        $this->showEditModal = true;
    }

    public function showEditModal(Supplier $supplier)
    {
        $this->editing = $supplier;
        if (isset($this->editing->photo))
            $this->photoUrl = Storage::disk('suppliers')->url($this->editing->photo);

        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Supplier $supplier)
    {
        $this->editing = $supplier;
        if (isset($this->editing->photo))
            $this->photoUrl = Storage::disk('suppliers')->url($this->editing->photo);

        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveSupplier()
    {

        $this->validate();

        if (isset($this->photo)) {

            if (isset($this->editing->photo))
                Storage::disk('suppliers')->delete($this->editing->photo);

            $this->editing->photo = $this->photo->store('/', 'suppliers');
        }

        if ($this->editing->save())
            $this->notify(false, __('messages.supplier-saved'));

        $this->showEditModal = false;
        $this->resetSupplier();
        $this->showEdit = false;
    }

    public function resetSupplier()
    {
        $this->editing = Supplier::make();
        $this->photo = null;
        $this->photoUrl = null;
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Supplier $deleting;

    public function showDelete(Supplier $supplier)
    {
        $this->deleting = $supplier;
        $this->showDelete = true;
    }

    public function deleteSupplier()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.supplier-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        return [
            'editing.name' => 'required|min:3',
            'editing.company' => 'nullable|min:3|unique:suppliers,company,' . $this->editing->id,
            'editing.phone' => 'nullable|numeric|digits:11',
            'photo' => 'nullable|image|max:1024',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'editing.phone' => __('fields.phone'),
            'editing.company' => __('fields.company'),
            'photo' => __('fields.photo'),
        ];
    }

    public function mount()
    {

        $this->resetSupplier();
    }

    public function render()
    {
        return view('livewire.admin.suppliers', [
            'suppliers' => Supplier::select('id', 'name', 'company', 'phone', 'photo', 'created_at')

                ->whereStatus('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get()
        ]);
    }
}
