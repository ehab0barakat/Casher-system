<?php

namespace App\Http\Livewire\Admin;

use App\Models\DailyReport;
use Livewire\Component;
use Carbon\Carbon;
use Tests\Feature\UpdatePasswordTest;

class DailyReports extends Component
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
        $shift = DailyReport::whereBetween('created_at', [carbon::today(), Carbon::now()])->sum("total");
        if($this->startDate == null || $this->endDate == null){
            $itemsList = DailyReport::orderByDesc("created_at")
            ->paginate(30);
        }else{
            $itemsList = DailyReport::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderByDesc("created_at")
            ->paginate(30);
        }

        return view('livewire.admin.dailyReports' , [
            'itemsList' => $itemsList ,
            'shift' => $shift ,
        ]);
    }
}
