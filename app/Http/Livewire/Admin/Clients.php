<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use App\Traits\WithClientAddModal;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Traits\WithNotify;
use App\Traits\WithSimpleSearch;

class Clients extends Component
{
    use WithClientAddModal;
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
    //MOVED $editing IN ADD MODAL TRAIT

    //FOR ADD/EDIT DIALOG
    //MOVED $showEditModal IN ADD MODAL TRAIT

    public function showEditModal(Client $client)
    {
        $this->editing = $client;
        $this->resetValidation();
        $this->showEditModal = true;
    }

    // FOR EDIT
    public $showEdit = false;

    public function showEdit(Client $client)
    {
        $this->editing = $client;
        $this->resetValidation();
        $this->showEdit = true;
    }

    public function saveClient()
    {
        $this->parentSaveClient();
        $this->showEdit = false;
    }

    public function resetClient()
    {
        $this->parentResetClient();
        $this->showEdit = false;
    }

    // FOR DELETE
    public $showDelete = false;
    public Client $deleting;

    public function showDelete(Client $client)
    {
        $this->deleting = $client;
        $this->showDelete = true;
    }

    public function deleteClient()
    {

        if ($this->deleting->status == '1') {

            $this->deleting->status = '0';
            if ($this->deleting->save())
                $this->notify(false, __('messages.client-deleted'));
        }

        $this->showDelete = false;
    }

    //COMPONENT
    public function mount()
    {

        $this->resetClient();
    }

    public function render()
    {
        return view('livewire.admin.clients', [
            'clients' => Client::select('id', 'name', 'phone', 'created_at')

                ->whereStatus('1')

                ->search('name', $this->searchQuery)

                ->orderBy($this->field, $this->direction)

                ->get()
        ]);
    }
}
