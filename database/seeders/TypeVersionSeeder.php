<?php

namespace Database\Seeders;

use App\Models\Core\TypeVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeVersion::create(['name' => 'Administration', 'color' => "#47FCA0"]);
        TypeVersion::create(['name' => 'Agence', 'color' => "#821C99"]);
        TypeVersion::create(['name' => 'API', 'color' => "#2D0450"]);
        TypeVersion::create(['name' => 'CI', 'color' => "#c2e0c6"]);
        TypeVersion::create(['name' => 'Client', 'color' => "#E2B9E5"]);
        TypeVersion::create(['name' => 'Correction', 'color' => "#7F3BB8"]);
        TypeVersion::create(['name' => 'Nouvelle Fonction', 'color' => "#168700"]);
        TypeVersion::create(['name' => 'Front', 'color' => "#22A49E"]);
    }
}
