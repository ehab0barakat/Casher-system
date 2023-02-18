<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $supplier = Supplier::inRandomOrder()->first();
        $name = $this->faker->unique()->name();

        return [
            'supplier_id' => $supplier->id,
            'name' => $name,

            'category_id' => $this->faker->numberBetween(1, Category::all()->count()),

            'quantity' => $this->faker->numberBetween(1, 999),
            'retailPrice' => $this->faker->numberBetween(100, 500),
            'costPrice' => $this->faker->numberBetween(501, 1000),
            'barcodeId' => $this->faker->unique()->numberBetween(111111,999999999),
        ];
    }
}
