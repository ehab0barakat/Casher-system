<?php

namespace App\Http\Livewire\Admin;

use App\Models\Branch;
use App\Models\User;
use Livewire\Component;
use App\Models\Permission;
use App\Models\UsersPermissions;
use App\Traits\WithNotify;
use App\Traits\WithSorting;
use App\Traits\WithSimpleSearch;

class Users extends Component
{

    use WithSimpleSearch;
    use WithSorting;
    use WithNotify;

    //FULL LIST
    public $permissions = null;
    public $branches = null;

    //FOR SEARCH
    public $showSearch = false;

    public function updatedShowSearch()
    {
        if (!$this->showSearch)
            $this->searchQuery = null;
    }

    //FOR BOTH DIALOG AND NORMAL
    public User $editing;
    public $selectedPermissions = [];
    //FOR ADD/EDIT DIALOG
    public $showEditModal = false;

    public function showAddModal()
    {
        $this->editing = User::make();
        $this->selectedPermissions = [];
        $this->showEditModal = true;
    }

    public function showEditModal(User $user)
    {
        $this->editing = $user;
        $this->selectedPermissions = $this->editing->permissions->pluck('id')->toArray();
        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(User $user)
    {
        $this->editing = $user;
        $this->selectedPermissions = $this->editing->permissions->pluck('id')->toArray();
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveUser()
    {
        $this->validate();

        //VALIDATE SELECTED IDS IN PERMISSIONS LIST
        $result = Permission::isIdsValid($this->selectedPermissions, $this->permissions->pluck('id'));
        if (!$result)
            return $this->addError('selectedPermissions', __('messages.permission-invalid'));

        if ($this->editing->saveWithHash()) {
            if ($this->showEdit || $this->showEditModal)
                UsersPermissions::overwrite($this->editing, $this->selectedPermissions);
            else
                UsersPermissions::createPermissions($this->editing->id, $this->selectedPermissions);

            $this->notify(false, __('messages.user-saved'));
        }

        $this->showEditModal = false;
        $this->resetValidation();
        $this->resetUser();
        $this->showEdit = false;
    }

    public function resetUser()
    {
        $this->editing = User::make([
            //SELECT MAIN BRANCH AS DEFAULT
            'branch_id' => '1',
        ]);
        $this->selectedPermissions = [];
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public User $deleting;

    public function showDelete(User $user)
    {
        $this->deleting = $user;
        $this->showDelete = true;
    }

    public function deleteUser()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.user-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function rules()
    {
        return [
            'editing.name' => 'required|min:3',
            'editing.branch_id' => 'required|exists:branches,id',
            'editing.username' => 'required|min:3|unique:users,username,' . $this->editing->id,
            'editing.beforeHashPassword' => ($this->showEdit || $this->showEditModal) ? 'nullable|min:6' : 'required|min:6',
            'selectedPermissions' => 'required|array|min:1',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'editing.branch_id' => __('fields.branch'),
            'editing.username' => __('fields.username'),
            'editing.beforeHashPassword' => __('fields.password'),
            'selectedPermissions' => __('fields.permissions'),
        ];
    }

    public function mount()
    {
        $this->permissions = Permission::select('id', 'key')->get();
        $this->branches = Branch::select('id', 'name')->whereStatus('1')->get();
        $this->resetUser();
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => User::select('id', 'branch_id', 'name', 'username', 'created_at')

                ->whereStatus('1')

                ->whereVisible('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get(),

            'permissions' => $this->permissions,
            'branches' => $this->branches,
        ]);
    }
}
