<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => 1,
            'name' => $this->faker->name(),
            'phone' => '01212542565',
            'salary' => $this->faker->numberBetween(2000, 5000),
        ];
    }
}
