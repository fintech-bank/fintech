<?php

namespace Database\Factories\Customer;

use App\Models\Core\LoanPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerPret>
 */
class CustomerPretFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $amount_loan = rand(500,99999);
        $amount_interest = $amount_loan * 5.25 / 100;
        $amount_du = $amount_loan + $amount_interest;
        $duration = rand(3,300);

        $status = ['open','study','accepted','refused','progress','terminated','error'];
        $sts = $status[rand(0,6)];

        $ass_type = ['D','DIM','DIMC'];

        return [
            "uuid" => $this->faker->uuid(),
            "reference" => \Str::upper("PRT".\Str::random(8)),
            "amount_loan" => $amount_loan,
            "amount_interest" => $amount_interest,
            "amount_du" => $amount_du,
            "mensuality" => $amount_du / $duration,
            "duration" => round($duration * 12),
            "status" => $sts,
            "signed_customer" => $sts == 'accepted' || $sts == 'progress' || $sts == 'terminated',
            "signed_bank" => $sts == 'accepted' || $sts == 'progress' || $sts == 'terminated',
            "assurance_type" => $ass_type[rand(0,2)],
            "loan_plan_id" => LoanPlan::all()->random()->id,
        ];
    }
}
