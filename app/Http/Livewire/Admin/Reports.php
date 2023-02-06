<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Tests\Feature\UpdatePasswordTest;

class Reports extends Component
{








    // public $startDate = '2022-01-01';
    // public $endDate = '2022-07-30';

    public $startDate = null;
    public $endDate = null;

    public $date;


    public function updatedDate()
    {
        dd($this->date);
    }





    public function render()
    {

        if($this->startDate == null || $this->endDate == null){
            $itemsList = Order::select('id', 'user_id' , 'branch_id' , 'client_id'  , 'total' , 'created_at')
            // ->orderBy($this->field, $this->direction)
            ->get();
        }else{
            $itemsList = Order::select('id', 'user_id' , 'branch_id' , 'client_id'  , 'total' , 'created_at')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            // ->orderBy($this->field, $this->direction)
            ->get();
        }




        return view('livewire.admin.reports' , [
            'itemsList' => $itemsList
        ]);
    }
}
