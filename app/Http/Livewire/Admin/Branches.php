<?php

namespace App\Http\Livewire\Admin;

use App\Models\Branch;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithNotify;
use App\Traits\WithSimpleSearch;

class Branches extends Component
{
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
    public Branch $editing;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {

        $this->editing = Branch::make();
        $this->showEditModal = true;
    }

    public function showEditModal(Branch $branch)
    {
        $this->editing = $branch;
        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Branch $branch)
    {
        $this->editing = $branch;
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveBranch()
    {

        $this->validate();

        if ($this->editing->save())
            $this->notify(false, __('messages.branch-saved'));

        $this->showEditModal = false;
        $this->resetValidation();
        $this->resetBranch();
        $this->showEdit = false;
    }

    public function resetBranch()
    {
        $this->editing = Branch::make();
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Branch $deleting;

    public function showDelete(Branch $branch)
    {
        $this->deleting = $branch;
        $this->showDelete = true;
    }

    public function deleteBranch()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.branch-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        return [
            'editing.name' => 'required|min:3',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
        ];
    }

    public function mount()
    {
        $this->resetBranch();
    }

    public function render()
    {
        return view('livewire.admin.branches', [
            'branches' => Branch::select('id', 'name', 'created_at')

                ->whereStatus('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get()
        ]);
    }
}
