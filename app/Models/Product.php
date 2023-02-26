<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\Category;
use App\Util\Formatting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'quantity',
        'costPrice',
        'retailPrice',
        'barcodeId',
        'category_id',
    ];

    //FOREIGN
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function name()
    {
        return $this->name;
    }



    //FORMATTING
    public function getPhotoOrDefaultUrlAttribute()
    {
        if (isset($this->photo))
            return Storage::disk('products')->url($this->photo);
        else
            return asset('img/avatars/product.png');
    }

    public function getSupplierNameAndCompanyAttribute()
    {
        if($this->supplier){
            return $this->supplier->name . " ({$this->supplier->company})";
        }
        return 'No Supplier Data' ;
    }

    public function getCategoryNameAttribute()
    {
        if($this->category){
            return $this->category->name ;
        }
        return 'No Category Data' ;
    }
    public function getQuantityInThreeDigitsAttribute()
    {
        return Formatting::formatInThreeDigits($this->quantity);
    }

    public function getCostPriceInCurrencyAttribute()
    {
        return number_format($this->costPrice, 3) . ' ' . __('fields.EGP');
    }

    public function getRetailPriceInCurrencyAttribute()
    {
        return number_format($this->retailPrice, 3) . ' ' . __('fields.EGP');
    }

    //HELPERS
    public function setBarcodeIdAndSave()
    {

        if ($this->barcodeId != null){
           return $this->save();
        }

        //MIN LENGTH : 6
        //FORMULA userId then supplierId then productId
        $userId = auth()->user()->id;
        $supplierId = $this->supplier_id;
        $productId = $this->id;

        $this->barcodeId = "{$userId}{$supplierId}{$productId}";

        if (strlen($this->barcodeId) < 6) {

            $zerosCount = 6 - strlen($this->barcodeId);

            for ($i = 0; $i < $zerosCount; $i++) {

                $this->barcodeId = '0' . $this->barcodeId;
            }
        }

        return $this->save();
    }

    //STATIC
    public static function updateStock($productId, $newStock)
    {

        //MADE SURE ID EXISTS
        $product = self::find($productId);

        $product->quantity += $newStock;

        return $product->save();
    }

    public static function checkQuantityBeforeOrder($productId, $quantity)
    {

        $product = self::find($productId);

        if (isset($product)) {

            if ($quantity > $product->quantity) {
                return $product->name;
            }

            return null;
        }

        return $product->name;
    }

    public static function updateQuantity($productId, $quantity)
    {
        $product = self::find($productId);

        if (isset($product)) {

            $product->quantity = $product->quantity - $quantity;
            return $product->save();
        }
    }
}
