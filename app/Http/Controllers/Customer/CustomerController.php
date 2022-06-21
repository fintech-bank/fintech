<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user()->customers;

        return view('customer.dashboard', ['customer' => $customer]);
    }
}
