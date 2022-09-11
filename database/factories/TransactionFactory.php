<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "client_id" => $this->faker->numberBetween(1, 20),
            "branch_id" => $this->faker->numberBetween(1, 5),

            "type" => $this->faker->randomElement([
                "withdrawal",
                "deposit"
            ]),
            "status" => $this->faker->randomElement([
                "pending",
                "accepted",
                "rejected"
            ]),


            "amount" => $this->faker->randomFloat(3,  1,1000),
            "date" => $this->faker->dateTimeThisYear(),




        ];
    }
}
