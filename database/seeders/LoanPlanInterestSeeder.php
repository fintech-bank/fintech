<?php

namespace Database\Seeders;

use App\Models\Core\LoanPlanInterest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanPlanInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanPlanInterest::query()->create([
            'interest' => 4.39,
            'duration' => 96,
            "loan_plan_id" => 1
        ])->create([
            'interest' => 4.39,
            'duration' => 84,
            "loan_plan_id" => 2
        ])->create([
            'interest' => 4.39,
            'duration' => 84,
            "loan_plan_id" => 3
        ])->create([
            'interest' => 4.39,
            'duration' => 84,
            "loan_plan_id" => 4
        ])->create([
            'interest' => 4.39,
            'duration' => 84,
            "loan_plan_id" => 5
        ])->create([
            'interest' => 4.39,
            'duration' => 84,
            "loan_plan_id" => 6
        ])->create([
            'interest' => 1.25,
            'duration' => 300,
            "loan_plan_id" => 7
        ])->create([
            "interest" => 2.39,
            "duration" => 6,
            "loan_plan_id" => 8
        ])->create([
            "interest" => 7.89,
            "duration" => 24,
            "loan_plan_id" => 8
        ])->create([
            "interest" => 18.36,
            "duration" => 36,
            "loan_plan_id" => 8
        ]);
    }
}
