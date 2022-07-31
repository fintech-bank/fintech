<?php

namespace App\Helper;

use App\Models\Core\Package;

class ServiceHelper
{
    public static function getTypePrlvToArray()
    {
        $packages = Package::all();
        $arr = [];

        foreach ($packages as $package) {
            $arr[] = [
                'name' => $package->name,
            ];
        }

        return json_encode($arr);
    }

    public static function setTypePrlv($type)
    {
        switch ($type) {
            case 'Mensuel': return 'mensual';
            case 'Trimestriel': return 'trim';
            case 'Semestriel': return 'sem';
            case 'Ponctuel': return 'ponctual';
            default: return 'annual';
        }
    }
}
