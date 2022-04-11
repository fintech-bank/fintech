<?php

namespace Database\Seeders;

use App\Models\Core\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agency::create([
            "name" => "FINTECH Bank",
            "bic" => "FINFRPPXXX",
            "code_banque" => rand(10000,99999),
            "code_agence" => rand(10000,99999),
            "address" => "4 Rue du Coudray",
            "postal" => "44000",
            "city" => "Nantes Cedex 4",
            "country" => "FR",
            "online" => true
        ]);

        Agency::create([
            "name" => "FINTECH Bank Pays de la Loire",
            "bic" => "FINFRPPNAN",
            "code_banque" => rand(10000,99999),
            "code_agence" => rand(10000,99999),
            "address" => "4 Rue du Coudray",
            "postal" => "44000",
            "city" => "Nantes Cedex 4",
            "country" => "FR",
            "online" => false
        ]);
    }
}
