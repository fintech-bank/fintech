<?php


namespace App\Helper;


class CustomerFaceliaHelper
{
    public static function generateReference()
    {
        return rand(1000, 9999) . " " . rand(100, 999) . " " . rand(1000, 9999);
    }

    public static function calcComptantMensuality($wallet)
    {
        return $wallet->transactions()->where('type', 'facelia')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function calcOpsSepaMensuality($wallet)
    {
        return $wallet->transactions()->where('type', 'sepa')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function calcMensuality($comptant, $sepa)
    {
        return $comptant + $sepa;
    }
}
