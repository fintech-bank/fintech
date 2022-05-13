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

    public static function isDiffered($type_debit)
    {
        return $type_debit != 'differed' ? false : true;
    }

    public static function getDebit($debit)
    {
        return $debit == 'DIFFERED' ? "Différé" : "Immédiat";
    }

    public static function getType($type)
    {
        switch ($type) {
            case 'physique':
                return 'Physique';
                break;

            case 'virtuel':
                return 'Virtuel';
                break;
        }
    }

    public static function getContact($contact)
    {
        return $contact == 1 ? "OUI" : "NON";
    }

    public static function getCreditCard($number, $obscure = true)
    {
        if ($obscure == true) {
            return "XXXX XXXX XXXX " . \Str::substr($number, 12, 16);
        } else {
            return $number;
        }
    }
}
