<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerFaceliaHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        //dd(auth()->user()->customers->wallets()->where('customer_id', auth()->user()->customers->id)->where('type', '!=', 'pret')->where('status', 'active')->get());

        return view('customer.payment.index', [
            'customer' => auth()->user()->customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'wallet_id' => 'required',
        ]);

        $request->merge([
            'debit' => $request->get('debit') != null ? $request->get('debit') : 'immediate',
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

                if ($request->get('facelia') == 1) {
                    // Vérification pour crédit facelia
                    if (CustomerFaceliaHelper::verifCompatibility($wallet->customer, $card) >= 2) {
                        // Inscription pour crédit facelia
                        CustomerFaceliaHelper::create($wallet, $wallet->customer, 500, $card);
                        $card->update([
                            'facelia' => 1,
                        ]);
                        $facelia = true;
                    } else {
                        $facelia = false;
                    }
                } else {
                    $facelia = false;
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
                $facelia = false;
            }

            return response()->json([
                'card' => $card,
                'facelia' => $facelia,
            ]);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json($exception->getMessage(), 500);
        }
    }

    public function show($card)
    {
        return view('customer.payment.show', [
            'card' => \App\Models\Customer\CustomerCreditCard::find($card),
            'customer' => auth()->user()->customers,
        ]);
    }

    public function update(Request $request, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        switch ($request->get('action')) {
            case 'updateState':
                return $this->updateState($request, $card);
                break;

            case 'updatePlafond':
                return $this->editPlafond($request, $card);
                break;
        }
    }

    private function updateState($request, $card)
    {
        try {
            $card->update([
                'payment_internet' => $request->has('payment_internet') ? 1 : 0,
                'payment_abroad' => $request->has('payment_abroad') ? 1 : 0,
                'payment_contact' => $request->has('payment_contact') ? 1 : 0,
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json([
                'errors' => [
                    $exception->getMessage(),
                ],
            ], 500);
        }
    }

    private function editPlafond($request, $card)
    {
        $limit_retrait_max = round($card->limit_retrait * 3, -2);
        $limit_payment_max = round($card->limit_payment * 1.23, -2);

        if ($request->get('limit_retrait') > $limit_retrait_max) {
            return response()->json(['errors' => ['Le Plafond de retrait est limité à '.eur($limit_retrait_max)]], 500);
        }

        if ($request->get('limit_payment') > $limit_payment_max) {
            return response()->json(['errors' => ['Le Plafond de paiement est limité à '.eur($limit_payment_max)]], 500);
        }

        try {
            $card->update([
                'limit_retrait' => $request->get('limit_retrait'),
                'limit_payment' => $request->get('limit_payment'),
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json([
                'errors' => [
                    $exception->getMessage(),
                ],
            ], 500);
        }
    }
}
