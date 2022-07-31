<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerCheck>
 */
class CustomerCheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reference = rand(1000000, 9999999);
        $status = ['checkout', 'manufacture', 'ship', 'outstanding', 'finish', 'destroy'];

        return [
            'reference' => $reference,
            'tranche_start' => $reference,
            'tranche_end' => $reference + 40,
            'status' => $status[rand(0, 5)],
        ];
    }
}
