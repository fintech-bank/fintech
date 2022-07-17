<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerFaceliaHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('customer.payment.index', [
            'customer' => auth()->user()->customers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => "required",
            'wallet_id' => "required"
        ]);

        $request->merge([
            'debit' => $request->get('debit') != null ? $request->get('debit') : 'immediate'
        ]);

        $wallet = CustomerWallet::find($request->get('wallet_id'));

        try {
            if ($request->get('type') == 'physique') {
                $card = CustomerCreditCard::createCard(
                    auth()->user()->customers,
                    $wallet,
                    'physique',
                    $request->get('support'),
                    $request->get('debit')
                );

                if ($request->has('facelia')) {
                    // Vérification pour crédit facelia
                    if (CustomerFaceliaHelper::verifCompatibility($wallet->customer, $card) >= 2) {
                        // Inscription pour crédit facelia
                        CustomerFaceliaHelper::create($wallet, $wallet->customer, 500, $card);
                        $card->update([
                            'facelia' => 1
                        ]);
                    }
                }
            } else {
                $card = CustomerCreditCard::createCard(
                    auth()->user()->customers,
                    $wallet,
                    'virtuel',
                    'classic',
                    'immediate',
                    $request->get('amount')
                );
            }

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception->getMessage(), 500);
        }
    }
}
