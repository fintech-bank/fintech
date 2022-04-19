<?php


namespace App\Helper;


class PackageHelper
{
    public static function getTypePrlvToArray()
    {
        return json_encode([
            [
                "name" => "Mensuel",
            ],
            [
                "name" => "Trimestriel",
            ],
            [
                "name" => "Semestriel",
            ],
            [
                "name" => "Annuel",
            ],
        ]);
    }
}
