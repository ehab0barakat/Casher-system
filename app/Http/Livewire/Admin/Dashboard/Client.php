<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Client as ClientModel;
use App\Traits\WithClientAddModal;
use App\Traits\WithNotify;
use Livewire\Component;

class Client extends Component
{

    use WithNotify;
    use WithClientAddModal;

    public ClientModel $selectedClient;

    protected $listeners = ['reset' => 'resetSelf'];

    public function resetSelf()
    {
        $this->selectClient = ClientModel::make();
        $this->searchType = '0';
        $this->searchName = '';
        $this->searchPhone = '';
        $this->clients = [];
    }

    //SELECTED INDEX
    // 0 => NAME
    // 1 => PHONE
    public $searchType = '0';

    //INPUTS
    public $searchName = '';
    public $searchPhone = '';

    public $clients = [];

    //SELECT CLIENT AFTER SEARCH
    public function selectClient(ClientModel $client)
    {

        $this->selectedClient = $client;
        $this->emitUp('selectedClient', $this->selectedClient->id);
    }

    //EMPTY DISABLED FIELD AFTER TYPE UPDATE
    public function updatingSearchType($newType)
    {

        if ($newType == '0')
            $this->searchPhone = '';
        else
            $this->searchName = '';
    }

    //SEARCH FOR CLIENTS USING NAME
    public function updatedSearchName()
    {
        if ($this->searchName == '')
            return $this->clients = [];

        if ($this->searchType == '0') {

            $this->clients = ClientModel::search('name', $this->searchName)->get();
            if ($this->clients->isNotEmpty()) {
                $this->selectedClient = $this->clients->first();
                $this->emitUp('selectedClient', $this->selectedClient->id);
            }
        }
    }

    //SEARCH FOR CLIENTS USING PHONE
    public function updatedSearchPhone()
    {

        if ($this->searchPhone == '')
            return $this->clients = [];


        if ($this->searchType == '1') {
            $this->clients = ClientModel::search('phone', $this->searchPhone)->get();

            if ($this->clients->isNotEmpty()) {
                $this->selectedClient = $this->clients->first();
                $this->emitUp('selectedClient', $this->selectedClient->id);
            }
        }
    }

    //ADD NEW CLIENT
    public function saveClient()
    {
        $newClient = $this->parentSaveClient();
        $this->clients = [$newClient];
        $this->selectedClient = $newClient;
        $this->emitUp('selectedClient', $this->selectedClient->id);
    }

    public function resetClient()
    {
        $this->parentResetClient();
    }

    //INITIALIZE SELECTED_CLIENT
    public function mount()
    {

        $this->resetClient();
        $this->selectedClient = ClientModel::make();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.client', [
            'clients' => $this->clients,
            'selectedClient' => $this->selectedClient,
        ]);
    }
}
