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
                "name" => $package->name
            ];
        }

        return json_encode($arr);
    }
}
