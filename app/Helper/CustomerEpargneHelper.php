<?php

namespace App\Helper;

class CustomerEpargneHelper
{
    public static function calcInterest($duration, $montant_actuel, $percent)
    {
        $first = $montant_actuel * $percent / 100;

        return $first / $duration;
    }
}
