<?php

namespace App\Helper;

use App\Models\Customer\CustomerWallet;
use IbanGenerator\Generator;

class CustomerWalletHelper
{
    public static function getTypeWallet($type, $label = false)
    {
        if ($label == true) {
            switch ($type) {
                case 'pret': return '<span class="badge badge-primary">Pret Bancaire</span>';
                    break;
                case 'compte': return '<span class="badge badge-success">Compte Courant</span>';
                    break;
                default: return '<span class="badge badge-success">Compte Epargne</span>';
                    break;
            }
        } else {
            switch ($type) {
                case 'pret': return 'Pret Bancaire';
                    break;
                case 'compte': return 'Compte Courant';
                    break;
                default: return 'Compte Epargne';
                    break;
            }
        }
    }

    public static function getStatusWallet($type, $label = false)
    {
        if ($label == true) {
            switch ($type) {
                case 'pending': return '<span class="badge badge-primary">En attente</span>';
                    break;
                case 'active': return '<span class="badge badge-success">Actif</span>';
                    break;
                case 'suspended': return '<span class="badge badge-warning">Suspendue</span>';
                    break;
                default: return '<span class="badge badge-danger">Clotûrer</span>';
                    break;
            }
        } else {
            switch ($type) {
                case 'pending': return 'En attente';
                    break;
                case 'active': return 'Actif';
                    break;
                case 'suspended': return 'Suspendue';
                    break;
                default: return 'Clotûrer';
                    break;
            }
        }
    }

    public static function getNameAccount($wallet)
    {
        return CustomerHelper::getName($wallet->customer).' - Compte courant N°'.$wallet->number_account;
    }

    /**
     * Création d'un compte
     *
     * @param  \Illuminate\Database\Eloquent\Model  $customer
     * @param  string  $type
     * @param  int  $balance_actual
     * @param  int  $balance_coming
     * @param  int  $decouvert
     * @param  int  $bal_decouvert
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function createWallet($customer, $type, $balance_actual = 0, $balance_coming = 0, $decouvert = 0, $bal_decouvert = 0, $status = 'pending')
    {
        $number_account = random_numeric(9);
        $ibanG = new Generator($customer->user->agency->code_banque, $number_account);

        $wallet = CustomerWallet::query()->create([
            'uuid' => \Str::uuid(),
            'number_account' => $number_account,
            'iban' => $ibanG->generate($customer->user->agency->code_banque, $number_account, 'FR'),
            'rib_key' => $ibanG->getBban($customer->user->agency->code_banque, $number_account),
            'type' => $type,
            'status' => $status,
            'balance_actual' => $balance_actual,
            'balance_coming' => $balance_coming,
            'decouvert' => $decouvert,
            'balance_decouvert' => $bal_decouvert,
            'customer_id' => $customer->id,
        ]);

        return $wallet;
    }

    public static function getSoldeRemaining($wallet)
    {
        return $wallet->balance_actual + $wallet->balance_decouvert;
    }

    public static function getSumMonthOperation($wallet)
    {
        return $wallet->transactions()->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', false)->orderBy('updated_at', 'desc')->sum('amount');
    }

    public static function calculateAmountStripe($amount):int
    {
        return $amount;
    }

}
