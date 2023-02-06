<?php

namespace App\Http\Livewire\Navigation;

use App\Models\Product;
use Livewire\Component;

class NavAdmin extends Component
{
    public function render()
    {
        return view(
            'livewire.navigation.nav-admin',
            [
                'notifications' => Product::where([
                    ['status', '=', '1'],
                    ['quantity', '<=', '2'],
                ])->get()
            ]
        );
    }
}
