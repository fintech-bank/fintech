<?php

namespace Database\Factories\Customer;

use App\Models\Core\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerBeneficiaire>
 */
class CustomerBeneficiaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = ['corporate', 'retail'];
        $tps = $type[rand(0, 1)];
        $civility = ['M', 'MME'];
        $civ = $civility[rand(0, 1)];
        $bank = Bank::all()->random();
        $firstname = $tps == 'retail' ? ($civ == 'M' ? $this->faker->firstName('male') : $this->faker->firstName('female')) : null;
        $lastname = $tps == 'retail' ? $this->faker->lastName : null;

        return [
            'uuid' => $this->faker->uuid,
            'type' => $tps,
            'company' => $tps == 'corporate' ? $this->faker->company() : null,
            'civility' => $tps == 'retail' ? $civ : null,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'currency' => 'EUR',
            'bankname' => $bank->name,
            'iban' => $this->faker->iban('FR'),
            'bic' => $this->faker->swiftBicNumber,
            'titulaire' => false,
            'bank_id' => $bank->id,
        ];
    }
}
