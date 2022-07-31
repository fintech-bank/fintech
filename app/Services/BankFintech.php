<?php

namespace App\Services;

class BankFintech
{
    public function callRefundSepa($sepa)
    {
        return \Http::get('http://bank.fintech.io/refund_request?bank_id='.$sepa)->object();
    }

    public function callStatusBank($bank_name)
    {
        return \Http::get('http://bank.fintech.io/status_request?bank_name='.$bank_name)->object();
    }

    public function callInter()
    {
        return \Http::get('http://bank.fintech.io/inter')->object();
    }
}
