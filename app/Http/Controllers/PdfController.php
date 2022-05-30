<?php

namespace App\Http\Controllers;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct()
    {

    }

    public function showRib($customer, $wallet)
    {
        $customer = Customer::find($customer);

        $pdf = Pdf::loadView('pdf.agence.rib', [
            'customer' => $customer,
            'data' => [
                'wallet' => CustomerWallet::find($wallet)
            ],
            'agence' => $customer->user->agency,
            'title' => "Rib",
            "header_type" => null,
        ]);
        return $pdf->stream('rib.pdf');
    }


}
