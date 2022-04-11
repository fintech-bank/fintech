<?php


namespace App\Helper;


class AgencyHelper
{
    public static function getCountryName($code)
    {
        $response = collect(\Http::get('https://restcountries.com/v3.1/alpha/' . $code)->object());
        return $response->first()->name->common;
    }

    public static function getOnline($online)
    {
        if ($online == true) {
            return '<span class="badge badge-success">Banque en ligne</span>';
        } else {
            return '<span class="badge badge-primary">Agence bancaire</span>';
        }
    }
}
