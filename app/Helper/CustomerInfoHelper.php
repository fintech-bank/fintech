<?php


namespace App\Helper;


class CustomerInfoHelper
{
    public static function getCivility($civility)
    {
        switch ($civility) {
            case 'M': return 'Monsieur';
            case 'Mme': return 'Madame';
            case 'Mlle': return 'Mademoiselle';
        }
    }
}
