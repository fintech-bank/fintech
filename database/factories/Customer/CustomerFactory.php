<?php

namespace Database\Factories\Customer;

use App\Models\Core\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $open = ["open", "completed", "accepted", "declined", "terminated"];
        return [
            "status_open_account" => $open[rand(0,4)],
            "auth_code" => base64_encode(1234),
            "agency_id" => Agency::all()->random()->id
        ];
    }
}
