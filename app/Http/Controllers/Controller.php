<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function changeLocale()
    {
        //MUST BE AUTHENTICATED
        if (auth()->user() != null) {

            if (app()->getLocale() == 'ar') {

                app()->setLocale('en');

                session()->put('locale', 'en');

                auth()->user()->locale = 'en';
                auth()->user()->save();

                return redirect()->back();
            } else {
                app()->setLocale('ar');

                session()->put('locale', 'ar');

                auth()->user()->locale = 'ar';
                auth()->user()->save();

                return redirect()->back();
            }
        }
    }

    public function showBarcode($productId)
    {

        $product = Product::find($productId);

        return view('barcode', [
            'product' => $product,
        ]);
    }
}
