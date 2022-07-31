<?php

namespace App\Helper;

class PackageHelper
{
    public static function getTypePrlvToArray()
    {
        return json_encode([
            [
                'name' => 'Mensuel',
            ],
            [
                'name' => 'Trimestriel',
            ],
            [
                'name' => 'Semestriel',
            ],
            [
                'name' => 'Annuel',
            ],
        ]);
    }

    public static function setTypePrlv($type)
    {
        switch ($type) {
            case 'Mensuel': return 'mensual';
            case 'Trimestriel': return 'trim';
            case 'Semestriel': return 'sem';
            default: return 'annual';
        }
    }

    public static function getTypePrlv($type)
    {
        switch ($type) {
            case 'mensual': return 'Mensuel';
            case 'trim': return 'Trimestriel';
            case 'sem': return 'Semestriel';
            default: return 'Annuel';
        }
    }
}
