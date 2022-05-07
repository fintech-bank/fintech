<?php

namespace Database\Factories\Customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Vicopo\Vicopo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerInfo>
 */
class CustomerInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = ["part", "pro"];
        $tps = $type[rand(0,1)];
        $civility = ["M", "Mme", "Mlle"];
        $civ = $civility[rand(0,2)];


        $postal = \Str::replace(" ", "", $this->faker->postcode);

        //dd(Carbon::createFromTimestamp($this->faker->dateTimeBetween('1900-01-01', '2004-01-01')->getTimestamp()));
        return [
            "type" => $tps,
            "civility" => $tps == 'part' ? $civ : null,
            "firstname" => $tps == 'part' ? ($civ == 'M' ? $this->faker->firstName('male') : $this->faker->firstName('female')) : null,
            "lastname" => $tps == 'part' ? $this->faker->lastName : null,
            "datebirth" => $tps == 'part' ? Carbon::createFromTimestamp($this->faker->dateTimeBetween('1900-01-01', '2004-01-01')->getTimestamp()) : null,
            "citybirth" => $tps == 'part' ? $this->faker->city() : null,
            "countrybirth" => $tps == 'part' ? $this->faker->countryCode() : null,
            "company" => $tps != 'part' ? $this->faker->company : null,
            "siret" => $tps != 'part' ? '52180906100059' : null,
            "address" => $this->faker->streetAddress,
            "addressbis" => $this->faker->boolean == true ? $this->faker->streetAddress : null,
            "postal" => $postal,
            "city" => $this->faker->city,
            "country" => "FR",
            "phone" => $this->faker->e164PhoneNumber(),
            "mobile" => $this->faker->e164PhoneNumber(),
            "isVerified" => $this->faker->boolean
        ];
    }
}
