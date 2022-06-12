<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerSituationHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\IbanHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\Customer\CreateCreditCardNotification;
use App\Notifications\Agent\Customer\CreateEpargneNotification;
use App\Notifications\Agent\Customer\CreatePretNotification;
use App\Notifications\Agent\Customer\CreateWalletNotification;
use App\Notifications\Customer\CreateWalletNotification as CreateWalletNotificationAlias;
use App\Notifications\Customer\SendCodeCardNotification;
use Carbon\Carbon;
use IbanGenerator\Generator;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function store(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);

        $number_account = rand(10000000000, 99999999999);
        $ibanC = new Generator($customer->user->agency->code_banque, $number_account, 'FR');
        $iban = $ibanC->generate();
        $rib_key = \Str::substr($iban, 18, 2);

        $wallet = $customer->wallets()->create([
            "uuid" => \Str::uuid(),
            "number_account" => $number_account,
            "iban" => $iban,
            "rib_key" => $rib_key,
            "status" => "pending",
            "decouvert" => $request->has('decouvert') ? true : false,
            "balance_decouvert" => $request->has('decouvert') ? $request->get('balance_decouvert') : 0,
            "customer_id" => $customer->id
        ]);

        if($request->get('action') == 'wallet') {
            try {
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
        } elseif($request->get('action') == 'epargne') {
            try {
                $wallet->update([
                    'type' => 'epargne'
                ]);
                $epargne = CustomerEpargne::create([
                    'uuid' => \Str::uuid(),
                    'reference' => \Str::upper(\Str::random(8)),
                    'initial_payment' => $request->get('initial_payment'),
                    'monthly_payment' => $request->get('monthly_payment'),
                    'monthly_days' => $request->get('monthly_days'),
                    'wallet_id' => $wallet->id,
                    'wallet_payment_id' => $request->get('wallet_payment_id'),
                    'epargne_plan_id' => $request->get('epargne_plan_id')
                ]);

                $doc_epargne = $customer->documents()->create([
                    'name' => "Contrat Compte Epargne",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => false,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                //Retrait Initial du compte bancaire
                $wallet_retrait = CustomerWallet::find($epargne->wallet_payment_id);
                CustomerTransactionHelper::create('debit', 'sepa', 'Prélèvement Contrat Epargne - '.$wallet->number_account, $request->get('initial_payment'), $wallet_retrait->id, true, 'Prélèvement Contrat Epargne - '.$wallet->number_account,now());
                CustomerTransactionHelper::create('credit', 'sepa', 'Prélèvement Contrat Epargne - '.$wallet->number_account, $request->get('initial_payment'), $wallet->id, true, 'Prélèvement Contrat Epargne - '.$wallet->number_account,  now());

                // Initialisation des Prélèvements Sepas
                for ($i=0; $i <= 24; $i++) {
                    CustomerSepa::query()->create([
                        'uuid' => \Str::uuid(),
                        'creditor' => CustomerHelper::getName($customer),
                        'number_mandate' => \Str::upper(\Str::random(8)),
                        'amount' => - $request->get('monthly_payment'),
                        'status' => 'waiting',
                        'created_at' => now(),
                        'updated_at' => now()->addMonths($i),
                        'customer_wallet_id' => $wallet_retrait->id
                    ]);

                    CustomerSepa::query()->create([
                        'uuid' => \Str::uuid(),
                        'creditor' => CustomerHelper::getName($customer),
                        'number_mandate' => \Str::upper(\Str::random(8)),
                        'amount' => $request->get('monthly_payment'),
                        'status' => 'waiting',
                        'created_at' => now(),
                        'updated_at' => now()->addMonths($i),
                        'customer_wallet_id' => $wallet->id
                    ]);
                }

                // Notification
                auth()->user()->notify(new CreateEpargneNotification($customer, $wallet, $doc_epargne));
                $customer->user->notify(new \App\Notifications\Customer\CreateEpargneNotification($customer, $wallet, $doc_epargne, $epargne));

                return response()->json([
                    'wallet' => $wallet,
                    'epargne' => $epargne,
                    'customer' => $customer
                ]);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage());
                return response()->json($exception->getMessage());
            }
        } else {
            try {
                $wallet->update([
                    'type' => 'pret'
                ]);

                $plan = LoanPlan::with('interests')->find($request->get('loan_plan_id'));
                $amount_interest = CustomerLoanHelper::getLoanInterest($request->get('amount_loan'), $plan->interests[0]->interest);
                $amount_du = $request->get('amount_loan') + $amount_interest;
                $mensuality = $amount_du / $request->get('duration');

                $pret = CustomerPret::create([
                    'uuid' => \Str::uuid(),
                    'reference' => \Str::upper(\Str::random(8)),
                    'amount_loan' => $request->get('amount_loan'),
                    'amount_interest' => $amount_interest,
                    'amount_du' => $amount_du,
                    'mensuality' => $mensuality,
                    'prlv_day' => $request->get('prlv_day'),
                    'duration' => $request->get('duration'),
                    'status' => 'open',
                    'signed_customer' => false,
                    'signed_bank' => true,
                    'assurance_type' => $request->get('assurance_type'),
                    'customer_wallet_id' => $wallet->id,
                    'wallet_payment_id' => $request->get('wallet_payment_id'),
                    'loan_plan_id' => $request->get('loan_plan_id'),
                    'customer_id' => $customer->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    "first_payment_at" => $request->get('prlv_day') != null ? Carbon::create(now()->year, now()->addMonth()->month, $request->get('prlv_day')) : now()->addMonth()
                ]);

                // Document Contractuel
                $customer->documents()->create([
                    'name' => $pret->reference." - Fiche de Dialogue",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => true,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $customer->documents()->create([
                    'name' => $pret->reference." - Information Précontractuel Normalisé",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => true,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $customer->documents()->create([
                    'name' => $pret->reference." - Assurance Emprunteur",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => false,
                    'signed_by_client' => false,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $customer->documents()->create([
                    'name' => $pret->reference." - Avis de conseil relatif à un produit d'assurance",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => false,
                    'signed_by_client' => false,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $doc_pret = $customer->documents()->create([
                    'name' => $pret->reference." - Offre de contrat de crédit: Pret Personnel",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => true,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                if($request->get('assurance_type') == 'D' || $request->get('assurance_type') == 'DIM' || $request->get('assurance_type') == 'DIMC' ) {
                    $customer->documents()->create([
                        'name' => $pret->reference." - Adhésion assurance facultative",
                        "reference" => \Str::upper(\Str::random(8)),
                        "signable" => true,
                        'signed_by_client' => true,
                        "customer_id" => $customer->id,
                        'document_category_id' => 3
                    ]);
                }

                $customer->documents()->create([
                    'name' => $pret->reference." - Mandat de prélèvement SEPA",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => true,
                    'signed_by_client' => true,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $customer->documents()->create([
                    'name' => $pret->reference." - Plan d'amortissement",
                    "reference" => \Str::upper(\Str::random(8)),
                    "signable" => false,
                    'signed_by_client' => false,
                    "customer_id" => $customer->id,
                    'document_category_id' => 3
                ]);

                $wallet_retrait = CustomerWallet::find($pret->wallet_payment_id);

                for ($i=1; $i <= $request->get('duration'); $i++) {
                    CustomerSepa::query()->create([
                        'uuid' => \Str::uuid(),
                        'creditor' => CustomerHelper::getName($customer),
                        'number_mandate' => \Str::upper(\Str::random(8)),
                        'amount' => - $mensuality,
                        'status' => 'waiting',
                        'created_at' => now(),
                        'updated_at' => now()->addMonths($i),
                        'customer_wallet_id' => $wallet_retrait->id
                    ]);

                    CustomerSepa::query()->create([
                        'uuid' => \Str::uuid(),
                        'creditor' => CustomerHelper::getName($customer),
                        'number_mandate' => \Str::upper(\Str::random(8)),
                        'amount' => $mensuality,
                        'status' => 'waiting',
                        'created_at' => now(),
                        'updated_at' => now()->addMonths($i),
                        'customer_wallet_id' => $wallet->id
                    ]);
                }


                // Notification
                auth()->user()->notify(new CreatePretNotification($customer, $wallet, $doc_pret));
                $customer->user->notify(new \App\Notifications\Customer\CreatePretNotification($customer, $wallet, $doc_pret, $pret));

                return response()->json([
                    'wallet' => $wallet,
                    'pret' => $pret,
                    'customer' => $customer
                ]);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage());
                return response()->json($exception->getMessage());
            }
        }
    }

    public function show($customer_id, $wallet_id)
    {
        $wallet = CustomerWallet::with('cards', 'transactions', 'sepas', 'transfers', 'epargne', 'checks')->find($wallet_id);

        //dd($wallet->loan);

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
