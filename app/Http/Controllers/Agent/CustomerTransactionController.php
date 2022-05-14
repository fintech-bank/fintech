<?php

namespace App\Http\Controllers\Agent;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Http\Request;

class CustomerTransactionController extends Controller
{
    public function store(Request $request, $customer, $wallet)
    {

        try {
            $transaction = CustomerTransaction::create([
                "uuid" => \Str::uuid(),
                "type" => 'frais',
                "designation" => $request->get('designation'),
                "description" => $request->get('description'),
                "amount" => $request->get('amount'),
                "confirmed" => $request->has('confirmed') ? 1 : 0,
                "confirmed_at" => $request->has('confirmed') ? now() : null,
                "customer_wallet_id" => $wallet
            ]);

            return response()->json($transaction);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    public function confirm($customer, $wallet, $transaction)
    {
        try {
            CustomerTransaction::find($transaction)->update([
                'confirmed' => true,
                'confirmed_at' => now()
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
