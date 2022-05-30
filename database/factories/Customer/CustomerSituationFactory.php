<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerSituation>
 */
class CustomerSituationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "legal_capacity" => "Majeur capable",
            "family_situation" => "Célibataire",
            "logement" => "Locataire",
            "logement_at" => $this->faker->dateTimeBetween(now()->subYears(rand(1,99)), now()),
            "child" => rand(0,9),
            "person_charged" => rand(0,5),
            "pro_category" => "Employé",
            "pro_category_detail" => "Employé de commerce",
            "pro_profession" => "Cuisinier"
        ];
    }
}
