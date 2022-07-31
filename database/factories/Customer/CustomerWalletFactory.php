<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerWallet>
 */
class CustomerWalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['pending', 'active', 'suspended', 'closed'];
        $dcs = [100, 200, 300, 400, 500, 800, 1000, 2000];
        $balance_actual = $this->faker->boolean(50) == true ? rand(0, 99999) : -rand(0, 99999);
        $balance_coming = $this->faker->boolean(50) == true ? rand(0, 9999) : -rand(0, 9999);
        $decouvert = $this->faker->boolean(33);
        $balance_decouvert = $decouvert == true ? $dcs[rand(0, 7)] : 0;

        return [
            'uuid' => $this->faker->uuid,
            'number_account' => $this->faker->randomNumber(9),
            'iban' => $this->faker->iban('FR'),
            'rib_key' => rand(10, 99),
            'status' => $status[rand(0, 3)],
            'balance_actual' => $balance_actual,
            'balance_coming' => $balance_coming,
            'decouvert' => $decouvert,
            'balance_decouvert' => $balance_decouvert,
        ];
    }
}
