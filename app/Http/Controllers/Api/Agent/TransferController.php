<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\CustomerTransferHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function info($id)
    {
        $transfer = CustomerTransfer::query()->find($id);

        if ($transfer->type == 'permanent') {
            return response()->json([
                'title' => 'Virement N°' . $transfer->reference,
                'wallet_customer' => [
                    'bank' => [
                        'name' => 'FINBANK',
                        'logo' => '/storage/logo/logo_carre_80.png'
                    ],
                    'name' => CustomerHelper::getName($transfer->wallet->customer),
                    'account' => 'Compte N°' . $transfer->wallet->number_account
                ],
                'wallet_beneficiaire' => [
                    'bank' => [
                        'name' => $transfer->beneficiaire->bank->name,
                        'logo' => $transfer->beneficiaire->bank->logo,
                    ],
                    'name' => CustomerTransferHelper::getNameBeneficiaire($transfer->beneficiaire),
                    'account' => $transfer->beneficiaire->iban
                ],
                'status' => CustomerTransferHelper::getStatusTransfer($transfer->status, true),
                'amount' => eur($transfer->amount),
                'reason' => $transfer->reason,
                'type' => CustomerTransferHelper::getTypeTransfer($transfer->type),
                'date' => [
                    'start' => $transfer->recurring_start->locale('fr_FR')->format('j F Y'),
                    'end' => $transfer->recurring_end->locale('fr_FR')->format('j F Y'),
                ],
                'typeText' => $transfer->type
            ]);
        } else {
            return response()->json([
                'title' => 'Virement N°' . $transfer->reference,
                'wallet_customer' => [
                    'bank' => [
                        'name' => 'FINBANK',
                        'logo' => '/storage/logo/logo_carre_80.png'
                    ],
                    'name' => CustomerHelper::getName($transfer->wallet->customer),
                    'account' => 'Compte N°' . $transfer->wallet->number_account
                ],
                'wallet_beneficiaire' => [
                    'bank' => [
                        'name' => $transfer->beneficiaire->bank->name,
                        'logo' => $transfer->beneficiaire->bank->logo,
                    ],
                    'name' => CustomerTransferHelper::getNameBeneficiaire($transfer->beneficiaire),
                    'account' => $transfer->beneficiaire->iban
                ],
                'status' => CustomerTransferHelper::getStatusTransfer($transfer->status, true),
                'amount' => eur($transfer->amount),
                'reason' => $transfer->reason,
                'type' => CustomerTransferHelper::getTypeTransfer($transfer->type),
                'date' => $transfer->transfer_date->locale('fr_FR')->format('j F Y'),
                'typeText' => $transfer->type
            ]);
        }
    }
}
