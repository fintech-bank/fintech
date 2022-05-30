<?php

namespace Database\Seeders;

use App\Models\Core\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::query()->create([
            'name' => "Cristal",
            'price' => 0,
            'type_prlv' => 'mensual',
        ]);

        Package::query()->create([
            'name' => "Gold",
            'price' => 4.99,
            'type_prlv' => 'mensual',
        ]);

        Package::query()->create([
            'name' => "Platine",
            'price' => 9.99,
            'type_prlv' => 'mensual',
        ]);
    }
}
