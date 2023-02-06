<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->numberBetween(1, 3);
        $cost = $this->faker->numberBetween(100, 3000);

        $metaData = json_encode(
            $type == 1 ?
                [
                    'name' => $this->faker->name(),
                    'cost' => $cost,
                ] : ($type == 2 ? ['cost' => $cost] : [
                    //GENERATING 100 IN SEED
                    'worker_id' => $this->faker->numberBetween(1, 100),
                    'cost' => $cost,
                ])
        );

        return [
            //FOR ADMIN
            'user_id' => '2',
            //FOR MAIN
            'branch_id' => '1',

            // 0 => NORMAL
            // 1 => RENT
            // 2 => SALARIES
            'type' => $type,

            // 0 => NORMAL      [NAME / COST]
            // 1 => RENT        [COST]
            // 2 => SALARIES    [WORKER_ID / COST]
            'metaData' => $metaData,
        ];
    }
}
