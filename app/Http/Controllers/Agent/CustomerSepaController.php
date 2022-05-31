<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerTransactionHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerSepa;
use App\Services\BankFintech;
use Illuminate\Http\Request;

class CustomerSepaController extends Controller
{
    public function show($customer, $wallet, $sepa)
    {
        $sepa = CustomerSepa::query()->find($sepa);

        return response()->json([
            'sepa' => $sepa,
            'url_refund' => route('agent.customer.wallet.sepas.refund', [$sepa->wallet->customer->id, $sepa->wallet->id, $sepa->id])
        ]);
    }

    public function refund_request(Request $request, $customer, $wallet, $sepa, BankFintech $bankFintech)
    {
        $sepa = CustomerSepa::query()->find($sepa);
        $call = $bankFintech->callRefundSepa($sepa->id);

        if($call == 1) {
            try {
                // Remboursement
                if($sepa->amount <= 0) {
                    CustomerTransactionHelper::create(
                        'credit',
                        'sepa',
                        "Remboursement ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                        - $sepa->amount,
                        $sepa->customer_wallet_id,
                        true,
                        "Remboursement ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                        now());
                } else {
                    CustomerTransactionHelper::create(
                        'debit',
                        'sepa',
                        "Remboursement ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                        "-".$sepa->amount,
                        $sepa->customer_wallet_id,
                        true,
                        "Remboursement ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                        now());
                }

                $sepa->status = 'refunded';
                $sepa->save();

                return response()->json();
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage());
                return response()->json(null, 500);
            }


        } else {
            return response()->json(null, 426);
        }
    }

    public function accept($customer, $wallet, $sepa)
    {
        $sepa = CustomerSepa::query()->find($sepa);

        try {
            if($sepa->amount <= 0) {
                CustomerTransactionHelper::create(
                    'debit',
                    'sepa',
                    "Prélèvement bancaire - ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                    - $sepa->amount,
                    $sepa->customer_wallet_id,
                    true,
                    "Prélèvement bancaire - ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                    now());
            } else {
                CustomerTransactionHelper::create(
                    'credit',
                    'sepa',
                    "Prélèvement bancaire -  ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                    $sepa->amount,
                    $sepa->customer_wallet_id,
                    true,
                    "Prélèvement bancaire -  ".$sepa->creditor." | ".$sepa->updated_at->format('d/m/Y'),
                    now());
            }

            $sepa->status = 'processed';
            $sepa->save();

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(null, 500);
        }
    }
    public function reject($customer, $wallet, $sepa)
    {
        $sepa = CustomerSepa::query()->find($sepa);

        try {

            $sepa->status = 'return';
            $sepa->save();

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(null, 500);
        }
    }
    public function opposit($customer, $wallet, $sepa)
    {
        $sepa = CustomerSepa::find($sepa);

        try {

            $sepa->creditor()->update([
                'opposit' => true
            ]);

            $sepa->status = 'rejected';
            $sepa->save();

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(null, 500);
        }
    }
}
