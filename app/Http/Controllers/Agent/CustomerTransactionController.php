<?php

namespace App\Http\Controllers\Agent;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CustomerTransactionController extends Controller
{
    public function store(Request $request, $customer, $wallet)
    {
        try {
            $transaction = CustomerTransaction::create([
                'uuid' => \Str::uuid(),
                'type' => 'frais',
                'designation' => $request->get('designation'),
                'description' => $request->get('description'),
                'amount' => $request->get('amount'),
                'confirmed' => $request->has('confirmed') ? 1 : 0,
                'confirmed_at' => $request->has('confirmed') ? now() : null,
                'customer_wallet_id' => $wallet,
            ]);

            return response()->json($transaction);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    public function confirm($customer, $wallet, $transaction)
    {
        try {
            $transaction = CustomerTransaction::find($transaction);
            $transaction->confirmed = true;
            $transaction->confirmed_at = now();
            $transaction->save();

            $wallet = CustomerWallet::find($wallet);
            $wallet->balance_coming = $wallet->balance_coming - $transaction->amount;
            $wallet->balance_actual = $wallet->balance_actual + $transaction->amount;
            $wallet->save();

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }
}
