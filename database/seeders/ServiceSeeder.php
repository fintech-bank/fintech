<?php

namespace Database\Seeders;

use App\Models\Core\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::query()->create([
            'name' => 'Abonnement Alerte PLUS',
            'price' => 2.90,
            'type_prlv' => 'mensual',
        ])->create([
            'name' => 'Tenue de Compte',
            'price' => 0,
            'type_prlv' => 'trim',
        ])->create([
            'name' => "Commission d'intervention",
            'price' => 2.50,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Ouverture Livret A Supplémentaire',
            'price' => 15.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Ouverture Livret LLDS Supplémentaire',
            'price' => 15.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Carte Physique supplémentaire',
            'price' => 25.00,
            'type_prlv' => 'ponctual',
        ])->create([
            'name' => 'Carte Virtuel supplémentaire',
            'price' => 10.00,
            'type_prlv' => 'ponctual',
        ]);
    }
}
