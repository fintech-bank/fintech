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
        $diff_limit = [500,1000,1500,2000,2500,3000];
        $card = [
            "currency" => "EUR",
            "exp_month" => now()->month,
            "exp_year" => now()->addYears(3)->year,
            "number" => $this->faker->creditCardNumber(),
            "status" => $status[rand(0,2)],
            "type" => "physique",
            "support" => $support[rand(0,2)],
            "debit" => $debit[rand(0,1)],
            "cvc" => rand(100,999),
            "code" => base64_encode(rand(1000,9999)),
            "limit_retrait" => rand(100,999),
            "limit_payment" => 2500,
            "facelia" => $this->faker->boolean(33),
        ];

        if($card['debit'] == 'differed') {
            $card += [
                "differed_limit" => $diff_limit[rand(0,5)],
            ];
        }

        if($card['support'] == 'premium') {
            $card += [
                "visa_spec" => true,
                "payment_abroad" => true
            ];
        } elseif($card['support'] == 'infinite') {
            $card += [
                "visa_spec" => true,
                "warranty" => true,
                "payment_abroad" => true
            ];
        } else {
            $card += [
                "visa_spec" => false,
                "warranty" => false,
                "payment_abroad" => false
            ];
        }

        return $card;
    }
}
