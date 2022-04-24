<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerCreditCard>
 */
class CustomerCreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['active','inactive','canceled'];
        $support = ['classic','premium','infinite'];
        $debit = ['immediate','differed'];
        return [
            "currency" => "EUR",
            "exp_month" => now()->month,
            "exp_year" => now()->addYears(3)->year,
            "number" => $this->faker->creditCardNumber(),
            "status" => $status[rand(0,2)],
            "type" => "physique",
            "support" => $support[rand(0,2)],
            "debit" => $debit[rand(0,1)],
            "cvc" => rand(100,999),
            "code" => rand(1000,9999),
            "limit_retrait" => rand(100,999),
            "limit_payment" => 2500
        ];
    }
}
