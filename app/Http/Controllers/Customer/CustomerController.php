<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user()->customers;
        //dd($customer->wallets()->where('type', 'pret')->get()->load('loan'));

        return view('customer.dashboard', ['customer' => $customer]);
    }

    public function offline()
    {
        return view('customer.offline');
    }
}
