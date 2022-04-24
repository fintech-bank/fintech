<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerSituationIncome>
 */
class CustomerSituationIncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "pro_incoming" => rand(500,9999),
            "patrimoine" => $this->faker->boolean(20) == true ? rand(1000,99999) : 0,
        ];
    }
}
