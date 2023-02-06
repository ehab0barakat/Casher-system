<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Worker;
use App\Models\Expense;
use Livewire\Component;
use App\Traits\WithNotify;
use App\Traits\WithSorting;
use App\Traits\WithSimpleSearch;

class Expenses extends Component
{

    use WithSimpleSearch;
    use WithSorting;
    use WithNotify;

    public $type = '0';

    public function updatedType()
    {
        if ($this->type == 2)
            $this->editing->metaData = [
                'worker_id' => '',
                'cost' => '',
            ];

        $this->resetValidation();
        $this->showEdit = false;
    }

    //FULL LIST
    public $workers;

    //FOR SEARCH
    public $showSearch = false;

    public function updatedShowSearch()
    {

        if (!$this->showSearch)
            $this->searchQuery = null;
    }

    //FOR BOTH DIALOG AND NORMAL
    public Expense $editing;

    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;
    public $showRentModal = false;
    public $showWorkerModal = false;

    public function showAddModal()
    {

        $this->editing = Expense::make();
        $this->type = '0';
        $this->showEditModal = true;
    }

    public function showRentModal()
    {

        $this->editing = Expense::make();
        $this->type = '1';
        $this->showRentModal = true;
    }

    public function showWorkerModal()
    {

        $this->editing = Expense::make();
        $this->type = '2';
        $this->editing->metaData = [
            'worker_id' => '',
            'cost' => '',
        ];
        $this->showWorkerModal = true;
    }

    public function showEditModal(Expense $expense)
    {
        $this->editing = $expense;
        $this->type = $this->editing->type;
        $this->editing->metaData = $this->editing->decodedMetaData;
        $this->resetValidation();
        switch ($this->type) {

            case '0':
                return $this->showEditModal = true;
            case '1':
                return $this->showRentModal = true;
            case '2':
                return $this->showWorkerModal = true;
        }
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Expense $expense)
    {
        $this->editing = $expense;
        $this->type = $this->editing->type;
        $this->editing->metaData = $this->editing->decodedMetaData;
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveExpense()
    {
        $this->validate();

        $this->editing->user_id = auth()->user()->id;
        $this->editing->branch_id = auth()->user()->branch_id;
        $this->editing->type = $this->type;

        if ($this->editing->saveWithJson())
            $this->notify(false, __('messages.expense-saved'));

        $this->showEditModal = false;
        $this->showRentModal = false;
        $this->showWorkerModal = false;
        $this->resetExpense();
        $this->showEdit = false;
    }

    public function resetExpense()
    {
        $this->editing = Expense::make();
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Expense $deleting;

    public function showDelete(Expense $expense)
    {
        $this->deleting = $expense;
        $this->showDelete = true;
    }

    public function deleteExpense()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.expense-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        $rules = [
            'editing.metaData.cost' => 'required|numeric|min:1'
        ];

        if ($this->type == 2)
            return array_merge($rules, ['editing.metaData.worker_id' => 'required|exists:workers,id']);
        else if ($this->type == 1)
            return $rules;
        else
            return array_merge($rules, ['editing.metaData.name' => 'required|min:3']);
    }

    public function validationAttributes()
    {
        return [
            'editing.metaData.name' => __('fields.name'),
            'editing.metaData.cost' => __('fields.cost'),
            'editing.metaData.worker_id' => __('fields.worker'),
        ];
    }

    public function mount()
    {
        $this->workers = Worker::select('id', 'name')->get();
        $this->resetExpense();
    }

    public function render()
    {
        $this->expenses = Expense::select(
            'id',
            'user_id',
            'branch_id',
            'type',
            'metaData',
            'created_at'
        )
            ->whereStatus('1')
            ->when($this->searchQuery, function ($query) {
                $query->whereDate(
                    'created_at',
                    Carbon::createFromFormat('d/m/Y', $this->searchQuery)->format('Y-m-d')
                );
            })
            ->orderBy($this->field, $this->direction)
            ->get();

        return view('livewire.admin.expenses', [
            'products' => $this->expenses,
            'workers' => $this->workers,
        ]);
    }
}
