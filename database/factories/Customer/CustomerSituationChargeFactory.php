<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerSituationCharge>
 */
class CustomerSituationChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $nb_credit = rand(0,5);
        return [
            "rent" => rand(0,1999),
            "nb_credit" => $nb_credit,
            "credit" => $nb_credit != 0 ? rand(100,900) : 0,
            "divers" => $this->faker->boolean == true ? rand(100,500) : 0
        ];
    }
}
