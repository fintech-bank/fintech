<?php


namespace App\Helper;


class CustomerSituationHelper
{
    public static function dataLegalCapacity()
    {
        return json_encode([
            [
                "name" => "Majeur Capable"
            ],
            [
                "name" => "Majeur sous tutelle"
            ],
            [
                "name" => "Mineur"
            ],
        ]);
    }

    public static function dataFamilySituation()
    {
        return json_encode([
            ["name" => "Célibataire"],
            ["name" => "Divorcé"],
            ["name" => "Marié"],
            ["name" => "Pacsé"],
            ["name" => "Séparé de corps"],
            ["name" => "Union Libre"],
            ["name" => "Veuf(ve)"],
        ]);
    }

    public static function dataLogement()
    {
        return json_encode([
            ["name" => "Propriétaire"],
            ["name" => "Locataire"],
            ["name" => "Logé par l'employeur"],
            ["name" => "Logé à titre gratuit"],
            ["name" => "Logé par les parents"],
            ["name" => "Sans Domicile Fixe"],
            ["name" => "Hôtel, Autres"],
        ]);
    }

    public static function dataProCategories()
    {
        return json_encode([
            ["name" => "Agriculteur"],
            ["name" => "Artisan, Commerçant, Chef d'Entreprise"],
            ["name" => "Cadre"],
            ["name" => "Employé"],
            ["name" => "Ouvriers"],
            ["name" => "Retraiter"],
            ["name" => "Sans Emploie"],
        ]);
    }
}
