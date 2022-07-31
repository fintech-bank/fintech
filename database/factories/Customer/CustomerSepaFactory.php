<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerSepa>
 */
class CustomerSepaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['waiting', 'processed', 'rejected', 'return', 'refunded'];

        return [
            'uuid' => $this->faker->uuid(),
            'creditor' => $this->faker->company,
            'number_mandate' => \Str::upper(\Str::random(rand(6, 15))),
            'status' => $status[rand(0, 4)],
        ];
    }
}
