<?php


namespace App\Helper;


class CustomerCreditCard
{
    public static function dataDebitCard()
    {

    }

    public static function calcLimitPayment($amount)
    {
        $calc = round($amount * 1.9, -2);

        return $calc;
    }

    public static function calcLimitRetrait($amount)
    {
        $calc = round($amount / 1.9, -2);

        return $calc;
    }
}
