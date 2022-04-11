<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Administrator",
            "email" => "admin@fintech.io",
            "password" => \Hash::make('password'),
            "admin" => true,
            "agent" => false,
            "customer" => false
        ]);

        User::create([
            "name" => "Agent",
            "email" => "agent@fintech.io",
            "password" => \Hash::make('password'),
            "admin" => false,
            "agent" => true,
            "customer" => false
        ]);

        User::create([
            "name" => "User",
            "email" => "user@fintech.io",
            "password" => \Hash::make('password'),
            "admin" => false,
            "agent" => false,
            "customer" => true
        ]);
    }
}
