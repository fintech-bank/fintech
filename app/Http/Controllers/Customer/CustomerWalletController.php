<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function index($wallet_id)
    {
        $wallet = CustomerWallet::find($wallet_id);
        $customer = $wallet->customer;

        return view('customer.wallet.index', compact('wallet', 'customer'));
    }
}
