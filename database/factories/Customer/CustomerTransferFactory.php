<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerTransfer>
 */
class CustomerTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $person = $this->faker->boolean == true ? $this->faker->name : $this->faker->company;
        $type = ['immediat','differed','permanent'];
        $tps = $type[rand(0,2)];

        $status = ['paid','pending','in_transit','canceled','failed'];

        return [
            "uuid" => $this->faker->uuid(),
            "reference" => \Str::upper(\Str::random(8)),
            "reason" => "Virement vers ".$person,
            "type" => $type,
            "transfer_date" => $tps == 'differed' ? now()->addDays(rand(1,30)) : null,
            "recurring_start" => $tps == 'permanent' ? now() : null,
            "recurring_end" => $tps == 'permanent' ? now()->addYears(rand(1,10)) : null,
            "status" => $status[rand(0,4)]
        ];
    }
}
