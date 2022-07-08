<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeneficiaireController extends Controller
{
    public function index()
    {
        return view('customer.transfer.beneficiaire', [
            'customer' => auth()->user()->customers
        ]);
    }
}
