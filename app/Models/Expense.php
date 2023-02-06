<?php

namespace App\Models;

use App\Util\Formatting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        // 0 => NORMAL
        // 1 => RENT
        // 2 => SALARIES
        'type',
        //IN JSON
        // 0 => NORMAL      [NAME / COST]
        // 1 => RENT        [COST]
        // 2 => SALARIES    [WORKER_ID / COST]
        'metaData',
    ];

    //FOREIGN KEYS
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    //FORMATTING
    public function getName($decodedMetaData)
    {

        // 0 => NORMAL      [NAME / COST]
        // 1 => RENT        [COST]
        // 2 => SALARIES    [WORKER_ID / COST]
        switch ($this->type) {
            case 0:
                return $decodedMetaData['name'] ?? __('fields.expense');
            case 1:
                return __('fields.rent');
            case 2:
                return isset($decodedMetaData['worker_id']) ?
                    Worker::getNameById($decodedMetaData['worker_id']) :
                    __('fields.worker');
        }
    }

    public function getCostInCurrency($decodedMetaData)
    {

        if (!isset($decodedMetaData['cost']))
            return __('fields.not-available');

        return number_format(
            $decodedMetaData['cost'],
            3
        ) . ' ' . __('fields.EGP');
    }

    public function getCreatedAtDateAttribute()
    {

        $day = $this->created_at->format('d ');
        $month = $this->created_at->format('M');
        $year = $this->created_at->format(' Y');

        return $day . Formatting::getFormattedMonth($month) . $year;
    }

    //HELPERS
    public function getDecodedMetaDataAttribute()
    {

        if (!isset($this->metaData) || empty($this->metaData))
            return [];

        return json_decode($this->metaData, true);
    }

    public function saveWithJson() {

        $this->metaData = json_encode($this->metaData);
        return $this->save();
    }
}
