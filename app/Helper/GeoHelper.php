<?php

namespace App\Helper;

class GeoHelper
{
    /**
     * Liste des Pays
     *
     * @return mixed
     */
    public static function getAllCountries()
    {
        return \Http::get('https://countriesnow.space/api/v0.1/countries/flag/images')->object()->data;
    }

    /**
     * Liste des villes par pays
     *
     * @param  string  $country // Pays sous format entier
     * @return mixed
     */
    public static function getCitiesFromCountry($country)
    {
        return \Http::post('https://countriesnow.space/api/v0.1/countries/cities', ['country' => \Str::lower($country)])->object()->data;
    }
}
