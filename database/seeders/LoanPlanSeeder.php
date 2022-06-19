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
            "minimum" => 500,
            "maximum" => 99999,
            "duration" => 96,
            "instruction" => "Des travaux intérieurs ou extérieurs sont nécessaires pour améliorer votre habitat ? Optez pour le prêt travaux"
        ])->create([
            "name" => "Crédit Auto Neuf",
            "minimum" => 500,
            "maximum" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Occasion -2 ans",
            "minimum" => 500,
            "maximum" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Occasion +2 ans",
            "minimum" => 500,
            "maximum" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Mobilier",
            "minimum" => 500,
            "maximum" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Personnel",
            "minimum" => 500,
            "maximum" => 75000,
            "duration" => 84,
            "instruction" => null
        ])->create([
            "name" => "Crédit Immobilier",
            "minimum" => 30000,
            "maximum" => 500000,
            "duration" => 300,
            "instruction" => null
        ])->create([
            'name' => "Crédit Renouvelable Facelia",
            "minimum" => 500,
            "maximum" => 3000,
            "duration" => 36,
            "instruction" => null
        ]);
    }
}
