<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerTransaction>
 */
class CustomerTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = ['depot', 'retrait', 'payment', 'virement', 'sepa', 'frais', 'souscription', 'autre'];

        switch ($type[rand(0, 6)]) {
            case 'depot': return $this->depot();
                break;
            case 'retrait': return $this->retrait();
                break;
            case 'payment': return $this->payment();
                break;
            case 'virement': return $this->virement();
                break;
            case 'sepa': return $this->sepa();
                break;
            case 'frais': return $this->frais();
                break;
            case 'souscription': return $this->souscription();
                break;
        }
    }

    private function depot()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'depot',
            'designation' => "Dépot d'argent sur votre compte",
            'amount' => rand(10, 1000),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function retrait()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'retrait',
            'designation' => "Retrait d'argent sur votre compte",
            'amount' => -rand(10, 1000),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function payment()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'payment',
            'designation' => 'CB '.$this->faker->company,
            'amount' => rand(10, 1000),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function virement()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'virement',
            'designation' => 'Virement depuis votre compte',
            'amount' => $this->faker->boolean(45) == true ? rand(10, 1000) : -rand(10, 1000),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function sepa()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'sepa',
            'designation' => 'Prélèvement SEPA '.$this->faker->company,
            'amount' => $this->faker->boolean(45) == true ? rand(1, 10) : -rand(1, 10),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function frais()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'frais',
            'designation' => 'Commission Bancaire',
            'amount' => $this->faker->boolean(15) == true ? rand(1, 10) : -rand(1, 10),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    private function souscription()
    {
        $confirmed = $this->faker->boolean(50) == true;

        return [
            'uuid' => $this->faker->uuid(),
            'type' => 'souscription',
            'designation' => 'Cotisation Pack Individual',
            'amount' => -rand(1, 10),
            'confirmed' => $confirmed,
            'confirmed_at' => $confirmed == true ? $this->faker->dateTimeBetween(now()->subYear(), now()) : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
