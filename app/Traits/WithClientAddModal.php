<?php

namespace App\Traits;

use App\Models\Client;

/**
 * simple searchQuery  from input field of a livewire component
 * must be with pagination
 */
trait WithClientAddModal
{
    public Client $editing;
    public $showEditModal = false;

    public function showAddModal()
    {
        $this->editing = Client::make();
        $this->showEditModal = true;
    }

    public function rules()
    {
        return [
            'editing.name' => 'required|min:3',
            'editing.phone' => 'required|numeric|digits:11',
        ];
    }

    public function validationAttributes()
    {
        return [
            'editing.name' => __('fields.name'),
            'editing.phone' => __('fields.phone'),
        ];
    }

    public function parentResetClient()
    {
        $this->editing = Client::make();
    }

    public function parentSaveClient()
    {

        $this->validate();

        if ($this->editing->save())
            $this->notify(false, __('messages.client-saved'));

        $this->resetValidation();

        $forReturn = $this->editing;

        $this->resetClient();
        $this->showEditModal = false;

        return $forReturn;
    }
}
