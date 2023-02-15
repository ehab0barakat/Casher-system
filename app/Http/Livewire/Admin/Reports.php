<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Carbon\Carbon;
use Tests\Feature\UpdatePasswordTest;

class Reports extends Component
{

    public $startDate = null;
    public $endDate = null;

    //LISTENERS
    protected $listeners = [
        'dateChange' => 'dateChange',
    ];

    public function dateChange($startDate , $endDate)
    {
        $this->startDate = $startDate ;
        $this->endDate = $endDate ;
    }

    public function render()
    {
        $shift = Order::whereBetween('created_at', [carbon::today(), Carbon::now()])->sum("total");
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
            'itemsList' => $itemsList ,
            'shift' => $shift ,
        ]);
    }
}
