<?php


namespace App\Services;


class BankFintech
{
    public function callRefundSepa($sepa)
    {
        return \Http::get('http://bank.fintech.io/refund_request?bank_id='.$sepa)->object();
    }
}
