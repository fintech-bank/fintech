<?php


namespace App\Helper;


use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;

class CustomerTransactionHelper
{
    public static function getTypeTransaction($type, $labeled = false, $symbol = false)
    {
        if($symbol == true) {
            switch ($type)
            {
                case 'depot':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Dépot">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/depot.png)"></div>
                            </div>';
                    break;

                case 'retrait':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Retrait">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/retrait.png)"></div>
                            </div>';
                    break;

                case 'payment':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Paiement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/payment.png)"></div>
                            </div>';
                    break;

                case 'virement':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Virement Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/virement.png)"></div>
                            </div>';
                    break;

                case 'sepa':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Prélèvement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/sepas.png)"></div>
                            </div>';
                    break;

                case 'frais':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Frais Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/frais.png)"></div>
                            </div>';
                    break;

                case 'souscription':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Souscription">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/souscription.png)"></div>
                            </div>';
                    break;

                case 'facelia':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Crédit Facelia">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/payment.png)"></div>
                            </div>';
                    break;

                default:
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Autre">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/autre.png)"></div>
                            </div>';
                    break;
            }
        } elseif ($labeled == true) {
            return '<span class="badge badge-'.random_color().'"></span>';
        } else {
            return \Str::ucfirst($type);
        }
    }

    public static function create($type, $type_transaction, $description, $amount, $wallet, $confirm = true, $designation = null, $confirmed_at = null, $updated_at = null)
    {
        if($type == 'debit') {
            CustomerTransaction::create([
                "uuid" => \Str::uuid(),
                "type" => $type_transaction,
                "designation" => $designation,
                "description" => $description == null ? $designation : $description,
                "amount" => 0.00 - (float)$amount,
                "confirmed" => $confirm,
                "confirmed_at" => $confirmed_at,
                "customer_wallet_id" => $wallet,
                "updated_at" => $updated_at
            ]);
            $transaction = CustomerTransaction::with('wallet')->latest()->first();

            $wallet = CustomerWallet::find($wallet);
            if($confirm == true) {
                $wallet->balance_actual += $transaction->amount;
                $wallet->save();
            } else {
                $wallet->balance_coming += $amount;
                $wallet->save();
            }
        } else {
            CustomerTransaction::create([
                "uuid" => \Str::uuid(),
                "type" => $type_transaction,
                "designation" => $designation,
                "description" => $description == null ? $designation : $description,
                "amount" => $amount,
                "confirmed" => $confirm,
                "confirmed_at" => $confirmed_at,
                "customer_wallet_id" => $wallet,
                "updated_at" => $updated_at
            ]);
            $transaction = CustomerTransaction::with('wallet')->latest()->first();

            $wallet = CustomerWallet::find($wallet);
            if($confirm == true) {
                $wallet->balance_actual += $transaction->amount;
                $wallet->save();
            } else {
                $wallet->balance_coming += $amount;
                $wallet->save();
            }
        }



        return $transaction;
    }

    public static function updated($transaction)
    {
        $transaction->wallet->update([
            'balance_actual' => $transaction->wallet->balance_actual + $transaction->amount,
            'balance_coming' => $transaction->wallet->balance_coming + $transaction->amount
        ]);

        $transaction->update([
            'confirmed' => true,
            'confirmed_at' => now()
        ]);
    }
}
