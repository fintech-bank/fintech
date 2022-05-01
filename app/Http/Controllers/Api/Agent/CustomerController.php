<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if($wallet->balance_actual <= 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "outdated"
                ];
            } else {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "ok"
                ];
            }
        }

        return $wallets;
    }
}
