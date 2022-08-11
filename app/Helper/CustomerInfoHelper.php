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
        $address = $info->address."<br>";
        $bis = $info->addressbis ? $info->addressbis."<br>" : '';

        ob_start();
        ?>
        <?= $address; ?>
        <?= $bis; ?>
        <?= $info->postal; ?> <?= $info->city; ?>
        <?php

        return ob_get_clean();
    }
}
