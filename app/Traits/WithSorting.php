<?php

namespace App\Traits;

/**
 * sorting support for dataTables in livewire components
 */
trait WithSorting
{
    public $field = 'created_at';
    public $direction = 'desc';

    protected $queryStringWithSorting = [
        'field', 'direction'
    ];

    public function sortBy($field)
    {
        
        if ($field == $this->field) {

            $this->direction = $this->direction == 'asc' ?
                'desc' : 'asc';
        } else {

            $this->field = $field;
            $this->direction = 'asc';
        }
    }
}
