<?php

namespace Database\Seeders;

use App\Models\Core\Package;
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
            'name' => 'Cristal',
            'price' => 0,
            'type_prlv' => 'mensual',
            'type_cpt' => 'part',
            'visa_classic' => 1,
            'check_deposit' => 0,
            'payment_withdraw' => 1,
            'overdraft' => 0,
            'cash_deposit' => 0,
            'withdraw_international' => 0,
            'payment_international' => 0,
            'payment_insurance' => 0,
            'check' => 0,
            'nb_carte_physique' => 1,
            'nb_carte_virtuel' => 0,
            'subaccount' => 0,
        ]);

        Package::query()->create([
            'name' => 'Gold',
            'price' => 4.99,
            'type_prlv' => 'mensual',
            'type_cpt' => 'part',
            'visa_classic' => 1,
            'check_deposit' => 1,
            'payment_withdraw' => 1,
            'overdraft' => 0,
            'cash_deposit' => 1,
            'withdraw_international' => 0,
            'payment_international' => 0,
            'payment_insurance' => 0,
            'check' => 1,
            'nb_carte_physique' => 1,
            'nb_carte_virtuel' => 5,
            'subaccount' => 0,
        ]);

        Package::query()->create([
            'name' => 'Platine',
            'price' => 9.99,
            'type_prlv' => 'mensual',
            'type_cpt' => 'part',
            'visa_classic' => 1,
            'check_deposit' => 1,
            'payment_withdraw' => 1,
            'overdraft' => 1,
            'cash_deposit' => 1,
            'withdraw_international' => 1,
            'payment_international' => 1,
            'payment_insurance' => 1,
            'check' => 1,
            'nb_carte_physique' => 5,
            'nb_carte_virtuel' => 5,
            'subaccount' => 1,
        ]);

        Package::query()->create([
            'name' => 'Pro Metal',
            'price' => 0,
            'type_prlv' => 'mensual',
            'type_cpt' => 'pro',
            'visa_classic' => 1,
            'check_deposit' => 0,
            'payment_withdraw' => 1,
            'overdraft' => 0,
            'cash_deposit' => 0,
            'withdraw_international' => 0,
            'payment_international' => 0,
            'payment_insurance' => 0,
            'check' => 0,
            'nb_carte_physique' => 1,
            'nb_carte_virtuel' => 0,
            'subaccount' => 0,
        ]);

        Package::query()->create([
            'name' => 'Pro Gold',
            'price' => 9.90,
            'type_prlv' => 'mensual',
            'type_cpt' => 'pro',
            'visa_classic' => 1,
            'check_deposit' => 1,
            'payment_withdraw' => 1,
            'overdraft' => 1,
            'cash_deposit' => 1,
            'withdraw_international' => 1,
            'payment_international' => 1,
            'payment_insurance' => 1,
            'check' => 1,
            'nb_carte_physique' => 5,
            'nb_carte_virtuel' => 5,
            'subaccount' => 1,
        ]);
    }
}
