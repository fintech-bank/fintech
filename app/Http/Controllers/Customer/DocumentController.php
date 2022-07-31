<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customers;
        $documents = $customer->documents;

        return view('customer.documents.index', compact('customer', 'documents'));
    }
}
