<?php

namespace App\Http\Controllers;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
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

    public function loanTable($customer, $wallet, $loan)
    {
        $loan = CustomerPret::find($loan);
        $customer = Customer::find($customer);
        $wallet = $loan->wallet;

        $pdf = Pdf::loadView('pdf.agence.amortissement', [
            'customer' => $customer,
            'data' => [
                'wallet' => CustomerWallet::find($wallet),
                'loan' => $loan
            ],
            'agence' => $customer->user->agency,
            'title' => "Tableau d'amortissement du pret bancaire N°".$loan->reference,
            "header_type" => "address",
            "document" => CustomerDocument::where('customer_id', $customer->id)->where('name', $loan->reference." - Plan d'amortissement")->first()
        ]);

        return $pdf->stream('amortissement.pdf');
    }


}
