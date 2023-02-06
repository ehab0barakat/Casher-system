<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        // 'service_id',
        'worker_id',
        'quantity',
    ];

    //FOREIGN KEYS
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function worker()
    {

        return $this->belongsTo(Worker::class, 'worker_id');
    }

    //FORMATTING
    public function getNameAttribute()
    {
        return $item->service->name . '( ' . $$item->worker->name . ' )';
    }

    public function getPriceInCurrencyAttribute()
    {
        return number_format($this->service->costPrice, 3) . ' ' . __('fields.EGP');
    }

    public function getQuantityInTwoDigitsAttribute()
    {
        return sprintf('%02d', $this->quantity);
    }

    public function getSubtotalInCurrencyAttribute()
    {
        return number_format($this->quantity * $this->service->costPrice, 3) . ' ' . __('fields.EGP');
    }
}
