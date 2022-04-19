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
    }
}
