<?php


namespace App\Helper;


use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;

class CustomerTransferHelper
{
    public static function getNameBeneficiaire($beneficiaire)
    {
        if ($beneficiaire->type == 'corporate') {
            return $beneficiaire->company;
        } else {
            return $beneficiaire->civility . '. ' . $beneficiaire->firstname . ' ' . $beneficiaire->lastname;
        }
    }

    public static function getTypeTransfer($type)
    {
        switch ($type) {
            case 'immediat':
                return 'Immédiat';
                break;
            case 'differed':
                return 'Differé';
                break;
            case 'permanent':
                return 'Permanent';
                break;
            default:
                return "Inconnue";
                break;
        }
    }

    public static function getStatusTransfer($status, $labeled = false)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'paid': return 'Executer'; break;
                case 'pending': return 'En Attente'; break;
                case 'in_transit': return 'En cours d\'exécution'; break;
                case 'canceled': return 'Annuler'; break;
                case 'failed': return 'Rejeter'; break;
                default: return 'Inconnue'; break;
            }
        } else {
            switch ($status) {
                case 'paid': return '<span class="badge badge-success"><i class="fa-solid fa-check me-2"></i> Exécuter</span>'; break;
                case 'pending': return '<span class="badge badge-warning"><i class="fa-solid fa-spinner fa-spin-pulse me-2"></i> En attente</span>'; break;
                case 'in_transit': return '<span class="badge badge-warning"><i class="fa-solid fa-spinner fa-spin-pulse me-2"></i> En cours d\'exécution</span>'; break;
                case 'canceled': return '<span class="badge badge-info"><i class="fa-solid fa-times me-2"></i> Annuler</span>'; break;
                case 'failed': return '<span class="badge badge-danger"><i class="fa-solid fa-triangle-exclamation fa-beat-fade me-2"></i> Rejeter</span>'; break;
                default: return '<span class="badge badge-info"><i class="fa-solid fa-triangle-exclamation fa-beat-fade me-2"></i> Inconnue</span>'; break;
            }
        }
    }


    /**
     * Execute le transfer et définie l'état à "Paid" si réussi ou "Failed" si échoué
     * @param $virement
     */
    public static function executeTransfer($virement)
    {
        $transfer = CustomerTransfer::query()->find($virement);
        $compte_beneficiaire = CustomerWallet::query()->where('iban', $transfer->beneficiaire->iban)->first();

        if($transfer->beneficiaire->titulaire == true) {
            if($compte_beneficiaire->status == 'active') {
                $transfer->wallet->balance_coming = $transfer->wallet->balance_coming - $transfer->amount;
                $transfer->wallet->balance_actual = $transfer->wallet->balance_actual + $transfer->amount;
                $transfer->wallet->save();

                $compte_beneficiaire->balance_actual = $compte_beneficiaire->balance_actual + $transfer->amount;
                $compte_beneficiaire->save();

                CustomerTransactionHelper::create('credit',
                'virement', $transfer->reason, $transfer->amount, $compte_beneficiaire->id,
                true, $transfer->reference.' - '.$transfer->reason,
                now());

                $transfer->status = 'paid';
                $transfer->save();

                return $transfer;

            } else {
                $transfer->status = 'failed';
                $transfer->save();

                return $transfer;
            }
        } else {
            $transfer->wallet->balance_coming = $transfer->wallet->balance_coming - $transfer->amount;
            $transfer->wallet->balance_actual = $transfer->wallet->balance_actual + $transfer->amount;
            $transfer->wallet->save();

            $transfer->status = 'paid';
            $transfer->save();

            return $transfer;
        }
    }

    public static function initTransfer($virement)
    {
        $transfer = CustomerTransfer::query()->find($virement);
        $compte_beneficiaire = CustomerWallet::query()->where('iban', $transfer->beneficiaire->iban)->first();


        if($transfer->transfer_date >= now()->startOfDay() && $transfer->transfer_date <= now()->endOfDay()) {
            if($transfer->beneficiaire->titulaire == true) {
                if($compte_beneficiaire->status == 'active') {
                    $transfer->wallet->balance_coming = $transfer->wallet->balance_coming - $transfer->amount;
                    $transfer->wallet->balance_actual = $transfer->wallet->balance_actual + $transfer->amount;
                    $transfer->wallet->save();

                    $compte_beneficiaire->balance_actual = $compte_beneficiaire->balance_actual + $transfer->amount;
                    $compte_beneficiaire->save();

                    CustomerTransactionHelper::create('credit',
                        'virement', $transfer->reason, $transfer->amount, $compte_beneficiaire->id,
                        true, $transfer->reference.' - '.$transfer->reason,
                        now());

                    $transfer->status = 'paid';
                    $transfer->save();

                    return $transfer;

                } else {
                    $transfer->status = 'failed';
                    $transfer->save();

                    return $transfer;
                }
            } else {
                $transfer->wallet->balance_coming = $transfer->wallet->balance_coming - $transfer->amount;
                $transfer->wallet->balance_actual = $transfer->wallet->balance_actual + $transfer->amount;
                $transfer->wallet->save();

                $transfer->status = 'paid';
                $transfer->save();

                return $transfer;
            }
        }
        return $transfer;
    }

    public static function programTransfer($virement)
    {

    }
}
