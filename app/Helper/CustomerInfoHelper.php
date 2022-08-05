<?php

namespace App\Helper;

use App\Models\Customer\CustomerInfo;

class CustomerInfoHelper
{
    public static function getCivility($civility)
    {
        switch ($civility) {
            case 'M':
                return 'Monsieur';
            case 'Mme':
                return 'Madame';
            case 'Mlle':
                return 'Mademoiselle';
        }
    }

    public static function getAddress(CustomerInfo $info)
    {
        return `$info->address<br>$info->addressbis ? $info->addressbis : null<br>$info->postal $info->city`;
    }
}
