<?php

namespace Database\Seeders;

use App\Models\Core\EpargnePlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpargnePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EpargnePlan::query()->create([
            'name' => "Livret A",
            "profit_percent" => 1.00,
            "lock_days" => 0,
            "profit_days" => 15,
            "init" => 10.00,
            "limit" => 22950.00
        ])->create([
            'name' => "Livret Developpement Durable et Solidaire (LDDS)",
            "profit_percent" => 1.00,
            "lock_days" => 0,
            "profit_days" => 15,
            "init" => 10,
            "limit" => 12000.00
        ])->create([
            'name' => "Livret Croissance",
            "profit_percent" => 0.20,
            "lock_days" => 180,
            "profit_days" => 30,
            "init" => 10,
            "limit" => 25000
        ])->create([
            'name' => "Livret Epargne FINTECH (LEF)",
            "profit_percent" => 0.10,
            "lock_days" => 0,
            "profit_days" => 15,
            "init" => 10,
            "limit" => 999999.00
        ]);
    }
}
