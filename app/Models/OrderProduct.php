<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'costPrice',
        'retailPrice',
        'costTotal',
        'retailTotal',
    ];

    //FOREIGN KEYS
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    //FORMATTING
    public function getNameAttribute()
    {

        return $this->product->name;
    }

    public function getPriceInCurrencyAttribute()
    {
        return number_format($this->product->retailPrice, 3) . ' ' . __('fields.EGP');
    }

    public function getQuantityInTwoDigitsAttribute()
    {
        return sprintf('%02d', $this->quantity);
    }

    public function getSubtotalInCurrencyAttribute()
    {

        return number_format($this->quantity * $this->product->retailPrice, 3) . ' ' . __('fields.EGP');
    }
}
