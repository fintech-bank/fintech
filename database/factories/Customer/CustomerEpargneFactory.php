<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerEpargne>
 */
class CustomerEpargneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $monthly_payment = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

        return [
            'uuid' => $this->faker->uuid(),
            'reference' => \Str::upper('EPS'.\Str::random(8)),
            'initial_payment' => rand(10, 100),
            'monthly_payment' => $monthly_payment[rand(0, 9)],
            'monthly_days' => rand(1, 30),
        ];
    }
}
