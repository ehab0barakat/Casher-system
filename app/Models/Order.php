<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'client_id',
        'subtotal',
        'discount',
        'total',
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

    public function client()
    {

        return $this->belongsTo(Client::class, 'client_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class,'order_id');
    }


    public function product_name($id)
    {
        return Product::find($id)->name ;
    }


    //FORMATTING
    public function getSubtotalInCurrencyAttribute($addSuffix = false)
    {

        $num = number_format($this->subtotal, 2);

        if ($addSuffix)
            $num .= ' ' . __('fields.EGP');

        return  $num;
    }

    public function getDiscountInCurrencyAttribute($addSuffix = false)
    {

        $num = number_format($this->discount, 2);

        if ($addSuffix)
            $num .= ' ' . __('fields.EGP');

        return  $num;
    }

    public function getTotalInCurrencyAttribute($addSuffix = false)
    {

        $num = number_format($this->total, 2);

        if ($addSuffix)
            $num .= ' ' . __('fields.EGP');

        return  $num;
    }
}
