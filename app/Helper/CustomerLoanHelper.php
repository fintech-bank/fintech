<?php


namespace App\Helper;


class CustomerLoanHelper
{
    public static function getLoanInterest($amount_loan, $interest_percent)
    {
        return $amount_loan * $interest_percent / 100;
    }

    public static function getTypeLoan($type)
    {

    }
}
