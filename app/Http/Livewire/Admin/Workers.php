<?php

namespace App\Http\Livewire\Admin;

use App\Models\Branch;
use App\Models\Worker;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithNotify;
use App\Traits\WithSimpleSearch;

class Workers extends Component
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
    public Worker $editing;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {

        $this->editing = Worker::make();
        $this->showEditModal = true;
    }

    public function showEditModal(Worker $worker)
    {
        $this->editing = $worker;
        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Worker $worker)
    {
        $this->editing = $worker;
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveWorker()
    {

        $this->validate();

        if ($this->editing->save())
            $this->notify(false, __('messages.worker-saved'));

        $this->showEditModal = false;
        $this->resetValidation();
        $this->resetWorker();
        $this->showEdit = false;
    }

    public function resetWorker()
    {
        $this->editing = Worker::make([
            'branch_id' => '1',
        ]);
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Worker $deleting;

    public function showDelete(Worker $worker)
    {
        $this->deleting = $worker;
        $this->showDelete = true;
    }

    public function deleteWorker()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.worker-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        return [
            'editing.name' => 'required|min:3',
            'editing.branch_id' => 'required|exists:branches,id',
            'editing.phone' => 'required|numeric|digits:11',
            'editing.salary' => 'required|numeric|min:100|max:50000',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'editing.branch_id' => __('fields.branch'),
            'editing.phone' => __('fields.phone'),
            'editing.salary' => __('fields.salary'),
        ];
    }

    public function mount()
    {
        $this->branches = Branch::select('id', 'name')->whereStatus('1')->get();
        $this->resetWorker();
    }

    public function render()
    {
        return view('livewire.admin.workers', [
            'workers' => Worker::select('id', 'branch_id', 'name', 'phone', 'salary', 'created_at')

                ->whereStatus('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get(),

            'branches' => $this->branches,
        ]);
    }
}
