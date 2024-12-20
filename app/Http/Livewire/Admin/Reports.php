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
            $itemsList = Order::orderByDesc("created_at")
            ->paginate(20);
        }else{
            $itemsList = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderByDesc("created_at")
            ->paginate(20);
        }

        return view('livewire.admin.reports' , [
            'itemsList' => $itemsList ,
            'shift' => $shift ,
        ]);
    }
}
