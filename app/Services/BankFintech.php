<?php

namespace App\Services;

use App\Models\Core\Agency;
use App\Models\Customer\Customer;

class BankFintech
{
    public function callRefundSepa($sepa)
    {
        return \Http::get('http://bank.fintech.io/refund_request?bank_id=' . $sepa)->object();
    }

    public function callStatusBank($bank_name)
    {
        return \Http::get('http://bank.fintech.io/status_request?bank_name=' . $bank_name)->object();
    }

    public function callInter()
    {
        return \Http::get('http://bank.fintech.io/inter')->object();
    }

    public function callTransferDoc(Customer $customer, Agency $agence, string $num_mandate)
    {
        return \Http::timeout(50)->post('http://bank.fintech.io/mobility/transfer_doc', [
            "customer" => $customer,
            "agence" => $agence,
            "num_mandate" => $num_mandate
        ])->object();
    }
}
