<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'phone',
        'salary',
    ];

    //FOREIGN KEYS
    public function branch()
    {

        return $this->belongsTo(Branch::class, 'branch_id');
    }

    //FORMATTING
    public function getSalaryInCurrencyAttribute()
    {
        return number_format($this->salary, 3) . ' ' . __('fields.EGP');
    }

    //STATIC
    public static function getNameById($id)
    {
        $worker = self::find($id);

        if (!isset($worker))
            return __('fields.worker');

        return $worker->name;
    }
}
