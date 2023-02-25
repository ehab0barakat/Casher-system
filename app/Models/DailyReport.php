<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        "day",
        "total",
        "capital",
        "capital_gross",
        "profit"
    ];



    public static function addOrUpdate($orderReport, $add = true)
    {
        $day = Carbon::now()->format("Y/m/d");

        $dailyReport = self::where("day", $day)->first();

        if ($dailyReport) {
            if ($add) {

                $dailyReport->total += $orderReport["total"];
                $dailyReport->capital += $orderReport["capital"];
                $dailyReport->capital_gross += $orderReport["capital_gross"];
                $dailyReport->profit += $orderReport["profit"];
                return $dailyReport->save();
            }else{
                $dailyReport->total -= $orderReport["total"];
                $dailyReport->capital -= $orderReport["capital"];
                $dailyReport->capital_gross -= $orderReport["capital_gross"];
                $dailyReport->profit -= $orderReport["profit"];
                return $dailyReport->save();
            }
        }

        $orderReport["day"] = $day;
        return self::create($orderReport);
    }
}
