<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerSituationHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\IbanHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\Customer\CreateCreditCardNotification;
use App\Notifications\Agent\Customer\CreateWalletNotification;
use App\Notifications\Customer\CreateWalletNotification as CreateWalletNotificationAlias;
use App\Notifications\Customer\SendCodeCardNotification;
use IbanGenerator\Generator;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function store(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);

        try {
            $number_account = rand(10000000000, 99999999999);
            $ibanC = new Generator($customer->user->agency->code_banque, $number_account, 'FR');
            $iban = $ibanC->generate();
            $rib_key = \Str::substr($iban, 18, 2);

            $wallet = $customer->wallets()->create([
                "uuid" => \Str::uuid(),
                "number_account" => $number_account,
                "iban" => $iban,
                "rib_key" => $rib_key,
                "status" => "active",
                "decouvert" => $request->has('decouvert') ? true : false,
                "balance_decouvert" => $request->has('decouvert') ? $request->get('balance_decouvert') : 0,
                "customer_id" => $customer->id
            ]);
            $doc_wallet = $customer->documents()->create([
                'name' => "Contrat Compte bancaire",
                "reference" => \Str::upper(\Str::random(8)),
                "signable" => true,
                'signed_by_client' => false,
                "customer_id" => $customer->id,
                'document_category_id' => 3
            ]);

            // Notification de création du compte bancaire (Agent/Client)
            auth()->user()->notify(new CreateWalletNotification($customer, $wallet, $doc_wallet));
            $customer->user->notify(new CreateWalletNotificationAlias($customer, $wallet, $doc_wallet));

            if($request->has('decouvert')) {
                $customer->documents()->create([
                    'name' => "Contrat Découvert",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => false,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);
            }

            $creditcard = new \Plansky\CreditCard\Generator();
            $card_number = $creditcard->single();
            $card_code = rand(1000, 9999);

            $credit_card = $wallet->cards()->create([
                "exp_month" => \Str::length(now()->month) <= 1 ? "0" . now()->month : now()->month,
                "number" => $card_number,
                "support" => $request->get('card_support'),
                "debit" => $request->get('card_debit'),
                "cvc" => rand(100, 999),
                "code" => base64_encode($card_code),
                "limit_payment" => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
                "limit_retrait" => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
                "customer_wallet_id" => $wallet->id
            ]);
            $doc_cb = $customer->documents()->create([
                'name' => "Contrat Carte Bancaire VISA",
                "reference" => \Str::upper(\Str::random(8)),
                "signable" => true,
                'signed_by_client' => false,
                "customer_id" => $customer->id,
                'document_category_id' => 3
            ]);

            // Notification de création de carte (Agent/Client)
            auth()->user()->notify(new CreateCreditCardNotification($customer, $credit_card, $doc_cb));
            $customer->user->notify(new \App\Notifications\Customer\CreateCreditCardNotification($customer, $credit_card, $doc_cb));

            // Envoie du code carte bancaire par SMS
            $customer->info->notify(new SendCodeCardNotification($customer, $credit_card->code, $credit_card));

            return response()->json([
                'wallet' => $wallet,
                'card' => $credit_card,
                'customer' => $customer
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }


    }

    public function show($customer_id, $wallet_id)
    {
        $wallet = CustomerWallet::with('cards', 'transactions', 'sepas', 'transfers', 'epargne', 'checks')->find($wallet_id);

        //dd($wallet->epargne->plan);

        return view('agent.customer.wallet.show', compact('wallet'));
    }

    public function decouvert($customer_id)
    {
        $customer = Customer::find($customer_id);

        $r = 0;
        $taux = 5.67;
        $incoming = $customer->income->pro_incoming;

        $result = $incoming / 3;

        if ($result <= 300) {
            $r--;
            $reason = "Votre revenue est inférieur à " . eur(1000);
        } else {
            $r++;
        }

        if ($customer->situation->pro_category != "Sans Emploie") {
            $r++;
        } else {
            $r--;
            $reason = "Votre situation professionnel ne permet pas un découvert bancaire";
        }

        if (CustomerWallet::where("customer_id", $customer->id)->where('type', 'compte')->get()->sum('balance_actual') >= 0) {
            $r++;
        } else {
            $r--;
            $reason = "La somme de vos comptes bancaires est débiteur.";
        }

        if (CustomerWallet::where('customer_id', $customer->id)->where("type", "compte")->get()->sum('balance_decouvert') > 0) {
            $r--;
            $reason = "Vous avez déjà un découvert";
        } else {
            $r++;
        }

        if ($r == 4) {
            return response()->json([
                "access" => true,
                "value" => $result > 1000 ? 1000 : ceil($result/100)*100,
                "taux" => $taux . " %"
            ]);
        } else {
            return response()->json([
                "access" => false,
                "error" => $reason
            ]);
        }
    }

    public function showRib($customer, $wallet)
    {
        $wallet = CustomerWallet::find($wallet);

        return view('agent.customer.wallet.rib', compact('wallet'));
    }

    public function requestDecouvert(Request $request, $customer, $wallet)
    {
        $wallet = CustomerWallet::find($wallet);

        if($request->get('balance_decouvert') > $request->get('balance_max')) {
            return response()->json("Montant Superieur a la limite autorise", 421);
        }

        try {
            $wallet->decouvert = true;
            $wallet->balance_decouvert = $request->get('balance_decouvert');
            $wallet->save();

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    public function update(Request $request, $customer, $wallet)
    {
        $wallet = CustomerWallet::find($wallet);

        switch ($request->get('action')) {
            case 'updateStatus':
                try {
                    $wallet->status = $request->get('status');
                    $wallet->save();

                    return response()->json([
                        'number_account' => $wallet->number_account,
                        'status' => CustomerWalletHelper::getStatusWallet($request->get('status'))
                    ]);
                }catch (\Exception $exception) {
                    return response()->json(api_error('err-0001', $exception->getMessage(), 'critical'));
                }
                break;
        }
    }
}
