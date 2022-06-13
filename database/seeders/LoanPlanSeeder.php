<?php

namespace Database\Seeders;

use App\Models\Core\LoanPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanPlan::query()->create([
            "name" => "Crédit Travaux",
            "min" => 500,
            "max" => 99999,
            "duration" => 96,
            "instruction" => "Des travaux intérieurs ou extérieurs sont nécessaires pour améliorer votre habitat ? Optez pour le prêt travaux"
        ])->create([
            "name" => "Crédit Auto Neuf",
            "min" => 500,
            "max" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Occasion -2 ans",
            "min" => 500,
            "max" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Occasion +2 ans",
            "min" => 500,
            "max" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Mobilier",
            "min" => 500,
            "max" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Personnel",
            "min" => 500,
            "max" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Immobilier",
            "min" => 30000,
            "max" => 500000,
            "duration" => 300,
            "instruction" => null
        ])->create([
            'name' => "Crédit Renouvelable Facelia",
            "min" => 500,
            "max" => 3000,
            "duration" => 36,
            "instruction" => null
        ]);
    }
}
