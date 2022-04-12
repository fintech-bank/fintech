<?php


namespace App\Helper;


class AgencyHelper
{
    public static function getOnline($online)
    {
        if ($online == true) {
            return '<span class="badge badge-success">Banque en ligne</span>';
        } else {
            return '<span class="badge badge-primary">Agence bancaire</span>';
        }
    }
}
