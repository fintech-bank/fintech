<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerTransferHelper;
use App\Helper\CustomerWalletHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;

class CustomerVirementController extends Controller
{
    public function store(Request $request, $customer, $wallet)
    {
        $date_permanent = $request->get('type') == 'permanent' ? explode(',', $request->get('permanent_date')) : null;
        $wallet = CustomerWallet::find($wallet);
        $beneficiaire = CustomerBeneficiaire::find($request->get('customer_beneficiaire_id'));

        // Vérification de l'état du compte
        if ($wallet->status != 'active') {
            return response()->json(api_error('cv-521', 'Le compte est actuellement '.CustomerWalletHelper::getStatusWallet($wallet->status).', Le virement ne peut être executer', 'warning'), 521);
        }

        try {
            switch ($request->get('type')) {
                case 'immediat':
                    if ($wallet->balance_actual <= 0) {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'immediat',
                            'transfer_date' => now(),
                            'status' => 'pending',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    } else {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'immediat',
                            'transfer_date' => now(),
                            'status' => 'in_transit',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    }
                    $transaction = CustomerTransactionHelper::create('debit', 'virement', 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire), $request->get('amount'), $wallet->id, false, 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire));
                    $trans->update([
                        'transaction_id' => $transaction->id,
                    ]);
                    break;

                case 'differed':
                    if ($wallet->balance_actual <= 0) {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'differed',
                            'transfer_date' => $request->get('transfer_date'),
                            'status' => 'pending',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    } else {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'differed',
                            'transfer_date' => $request->get('transfer_date'),
                            'status' => 'in_transit',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    }

                    $transaction = CustomerTransactionHelper::create('debit', 'virement', 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire), $request->get('amount'), $wallet->id, false, 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire));
                    $trans->update([
                        'transaction_id' => $transaction->id,
                    ]);
                    break;

                case 'permanent':
                    if ($wallet->balance_actual <= 0) {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'differed',
                            'recurring_start' => $date_permanent[0],
                            'recurring_end' => $date_permanent[1],
                            'status' => 'pending',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    } else {
                        $trans = $wallet->transfers()->create([
                            'uuid' => \Str::uuid(),
                            'amount' => $request->get('amount'),
                            'reference' => $request->get('reference') != '' ? $request->get('reference') : \Str::random(8),
                            'reason' => $request->get('reference') != '' ? $request->get('reference') : 'Virement vers le compte '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                            'type' => 'differed',
                            'recurring_start' => $date_permanent[0],
                            'recurring_end' => $date_permanent[1],
                            'status' => 'in_transit',
                            'customer_wallet_id' => $wallet->id,
                            'customer_beneficiaire_id' => $beneficiaire->id,
                        ]);
                    }
                    $transaction = CustomerTransactionHelper::create('debit', 'virement', 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire), $request->get('amount'), $wallet->id, false, 'Virement '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire));
                    $trans->update([
                        'transaction_id' => $transaction->id,
                    ]);
                    break;
            }

            return response()->json();
        } catch (\Exception $exception) {
            return response()->json(api_error('err-0001', $exception->getMessage(), 'critical'));
        }
    }

    public function accept(Request $request, $customer, $wallet, $transfer)
    {
        $transfer = CustomerTransfer::find($transfer);

        try {
            $transfer->status = 'in_transit';
            $transfer->save();

            return response()->json([
                'status' => CustomerTransferHelper::getStatusTransfer('in_transit'),
            ]);
        } catch (\Exception $exception) {
            return response()->json(api_error('err-0001', $exception->getMessage(), 'critical'));
        }
    }

    public function reject(Request $request, $customer, $wallet, $transfer)
    {
        $transfer = CustomerTransfer::find($transfer);

        try {
            $transfer->status = 'failed';
            $transfer->save();

            return response()->json([
                'status' => CustomerTransferHelper::getStatusTransfer('failed'),
            ]);
        } catch (\Exception $exception) {
            return response()->json(api_error('err-0001', $exception->getMessage(), 'critical'));
        }
    }
}
