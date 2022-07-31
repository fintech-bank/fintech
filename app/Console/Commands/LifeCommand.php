<?php

namespace App\Console\Commands;

use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Models\Core\DocumentCategory;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use App\Notifications\Customer\Automate\GenerateMensualReleverNotification;
use App\Notifications\Customer\Automate\NewPrlvPresented;
use Carbon\Carbon;
use IbanGenerator\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LifeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'life {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère des informations courante';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'generateCustomer':
                return $this->generateCustomer();

            case 'generateSalary':
                return $this->generateSalary();

            case 'generateDebit':
                return $this->generateDebit();

            case 'generatePrlvSepa':
                return $this->generatePrlvSepa();

            case 'generateMensualReleve':
                return $this->generateMensualReleve();

        }
    }

    private function generateCustomer()
    {
        $nb = rand(0, 5);

        $users = User::factory($nb)->create([
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 2,
        ]);

        try {
            foreach ($users as $user) {
                $customer = Customer::factory()->create([
                    'user_id' => $user->id,
                    'package_id' => Package::all()->random()->id,
                    'agent_id' => 2,
                ]);

                \Storage::disk('public')->makeDirectory('gdd/'.$customer->id);
                foreach (DocumentCategory::all() as $doc) {
                    \Storage::disk('public')->makeDirectory('gdd/'.$customer->id.'/'.$doc->id);
                }

                CustomerInfo::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                CustomerSetting::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                CustomerSituation::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                CustomerSituationCharge::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                CustomerSituationIncome::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                if ($customer->status_open_account == 'terminated') {
                    $account = CustomerWallet::factory()->create([
                        'type' => 'compte',
                        'customer_id' => $customer->id,
                    ]);

                    $doc_account = DocumentFile::createDoc(
                        $customer,
                        'Convention Part',
                        'Convention Particulier',
                        3,
                        null,
                        true,
                        true,
                        false,
                        true,
                        ['wallet' => $account]
                    );

                    CustomerBeneficiaire::factory(rand(1, 10))->create([
                        'customer_id' => $customer->id,
                    ]);

                    $card = CustomerCreditCard::factory()->create([
                        'customer_wallet_id' => $account->id,
                    ]);

                    $doc_card = DocumentFile::createDoc(
                        $customer,
                        'Convention cb physique',
                        'Convention Carte Bancaire VISA Physique',
                        3,
                        null,
                        true,
                        true,
                        false,
                        true,
                        ['card' => $card]
                    );

                    foreach (CustomerCreditCard::query()->where('facelia', 1)->where('customer_wallet_id', $account->id)->get() as $card) {
                        $amount = [500, 1000, 1500, 2000, 2500, 3000];
                        $amount_loan = $amount[rand(0, 5)];
                        $interest = CustomerLoanHelper::getLoanInterest($amount_loan, LoanPlan::find(8)->interests[0]->interest);
                        $du = $amount_loan + $interest;

                        $number_account = random_numeric(9);
                        $ibanG = new Generator($customer->user->agency->code_banque, $number_account, 'fr');

                        $cpt_pret = CustomerWallet::query()->create([
                            'uuid' => Str::uuid(),
                            'number_account' => $number_account,
                            'iban' => $ibanG->generate($customer->user->agency->code_banque, $number_account, 'fr'),
                            'rib_key' => $ibanG->getBban($customer->user->agency->code_banque, $number_account),
                            'type' => 'pret',
                            'status' => 'active',
                            'balance_actual' => $amount_loan,
                            'customer_id' => $customer->id,
                        ]);

                        $pr = CustomerPret::factory()->create([
                            'amount_loan' => $amount_loan,
                            'amount_interest' => $interest,
                            'amount_du' => $du,
                            'mensuality' => $du / 36,
                            'prlv_day' => 30,
                            'duration' => 36,
                            'status' => 'accepted',
                            'customer_wallet_id' => $cpt_pret->id,
                            'wallet_payment_id' => $card->wallet->id,
                            'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, 30),
                            'loan_plan_id' => 8,
                            'customer_id' => $customer->id,
                        ]);

                        $card->update([
                            'customer_pret_id' => $pr->id,
                        ]);

                        CustomerFacelia::query()->create([
                            'reference' => CustomerFaceliaHelper::generateReference(),
                            'amount_available' => $amount_loan,
                            'amount_interest' => 0,
                            'amount_du' => 0,
                            'mensuality' => 0,
                            'next_expiration' => null,
                            'customer_pret_id' => $pr->id,
                            'customer_credit_card_id' => $card->id,
                            'customer_wallet_id' => $cpt_pret->id,
                            'wallet_payment_id' => $card->wallet->id,
                        ]);

                        DocumentFile::createDoc(
                            $customer,
                            'Plan d\'amortissement',
                            $pr->reference." - Plan d'amortissement",
                            3,
                            null,
                            false,
                            false,
                            false,
                            true,
                            ['loan' => $pr]
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'Assurance Emprunteur',
                            $pr->reference.' - Assurance Emprunteur',
                            3,
                            null,
                            false,
                            false,
                            false,
                            true,
                            []
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'Avis de conseil relatif assurance',
                            $pr->reference.' - Avis de conseil Relatif au assurance emprunteur',
                            3,
                            null,
                            false,
                            false,
                            false,
                            true,
                            []
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'contrat de credit facelia',
                            $pr->reference.' - Contrat de Crédit FACELIA',
                            3,
                            null,
                            true,
                            true,
                            false,
                            true,
                            ['loan' => $pr]
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'Fiche de dialogue',
                            $pr->reference.' - Fiche de Dialogue',
                            3,
                            null,
                            false,
                            false,
                            false,
                            true,
                            []
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'Information précontractuel normalise',
                            $pr->reference.' - Information Précontractuel Normalisé',
                            3,
                            null,
                            true,
                            true,
                            false,
                            true,
                            ['loan' => $pr]
                        );

                        DocumentFile::createDoc(
                            $customer,
                            'Mandat Prélevement sepa',
                            $pr->reference.' - Mandat Prélèvement SEPA',
                            3,
                            null,
                            false,
                            false,
                            false,
                            true,
                            ['loan' => $pr]
                        );
                    }

                    // Transfers du salaire
                    CustomerTransactionHelper::create(
                        'credit',
                        'virement',
                        'Virement Salaire '.now()->monthName,
                        $customer->income->pro_incoming,
                        $account->id,
                        true,
                        'Virement Salaire '.now()->monthName,
                        now());

                    // Prise de la souscription
                    if ($customer->package->price > 0) {
                        CustomerTransactionHelper::create(
                            'debit',
                            'souscription',
                            'Cotisation Pack'.$customer->package->name.' - '.now()->monthName,
                            $customer->package->price,
                            $account->id,
                            true,
                            'Cotisation Pack'.$customer->package->name.' - '.now()->monthName,
                            now());
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

        $this->line('Nombre de nouveau client: '.$nb);

        return null;
    }

    private function generateSalary()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();

        foreach ($customers as $customer) {
            $wallet = $customer->wallets()->where('type', 'compte')->first();

            CustomerTransactionHelper::create(
                'credit',
                'virement',
                'Virement Salaire '.now()->monthName,
                $customer->income->pro_incoming,
                $wallet->id,
                true,
                'Virement Salaire '.now()->monthName,
                now());
        }

        $this->line('Check des virements des salaires terminer');

        return 0;
    }

    private function generateDebit()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();
        $nb = 0;

        foreach ($customers as $customer) {
            $wallet = $customer->wallets()->where('type', 'compte')->where('status', 'active')->first();
            if (isset($wallet)) {
                $select = rand(0, 2);
                $balance_wallet = $wallet->balance_actual + $wallet->balance_decouvert;

                if (rand(0, 1) == 1) {
                    try {
                        if ($balance_wallet > 0) {
                            $confirmed = rand(0, 1);
                            switch ($select) {
                                case 0:
                                    CustomerTransactionHelper::create(
                                        'credit',
                                        'depot',
                                        'Dépot sur votre compte',
                                        rand(100, 900),
                                        $wallet->id,
                                        $confirmed == 1 ? true : false,
                                        'Dépot sur votre compte | Ref: '.Str::upper(Str::random(8)),
                                        $confirmed == 1 ? now() : null,
                                        $confirmed == 0 ? now()->addDays(rand(1, 5)) : now());
                                    break;

                                case 1:
                                    CustomerTransactionHelper::create(
                                        'debit',
                                        'retrait',
                                        'Retrait sur votre compte',
                                        rand(100, 900),
                                        $wallet->id,
                                        $confirmed == 1 ? true : false,
                                        'Retrait sur votre compte | Ref: '.Str::upper(Str::random(8)),
                                        $confirmed == 1 ? now() : null,
                                        $confirmed == 0 ? now()->addDays(rand(1, 5)) : now());
                                    break;

                                case 2:
                                    if ($wallet->cards()->first()->status == 'active') {
                                        if ($wallet->cards()->first()->debit == 'differed') {
                                            $differed = rand(0, 1);
                                            CustomerTransactionHelper::create(
                                                'debit',
                                                'payment',
                                                'Paiement par Carte Bancaire',
                                                rand(100, 900),
                                                $wallet->id,
                                                $confirmed == 1 ? true : false,
                                                'Paiement par Carte Bancaire | Ref: '.Str::upper(Str::random(8)),
                                                $confirmed == 1 ? now() : null,
                                                $confirmed == 0 ? now()->addDays(rand(1, 5)) : now(), $wallet->cards()->first()->id,
                                                $differed == 1 ? true : false);
                                        } else {
                                            CustomerTransactionHelper::create(
                                                'debit',
                                                'payment',
                                                'Paiement par Carte Bancaire',
                                                rand(100, 900),
                                                $wallet->id,
                                                $confirmed == 1 ? true : false,
                                                'Paiement par Carte Bancaire | Ref: '.Str::upper(Str::random(8)),
                                                $confirmed == 1 ? now() : null,
                                                $confirmed == 0 ? now()->addDays(rand(1, 5)) : now(), $wallet->cards()->first()->id);
                                        }
                                    }
                                    break;
                            }
                            $nb++;
                        }
                    } catch (\Exception $exception) {
                        $this->error($exception->getMessage());
                    }
                }
            }
        }
        $this->line('Génération des Transactions: '.$nb);

        return 0;
    }

    private function generatePrlvSepa()
    {
        $customers = Customer::where('status_open_account', 'terminated')->get();

        foreach ($customers as $customer) {
            foreach ($customer->wallets->where('status', 'active')->where('type', 'compte') as $wallet) {
                if (rand(0, 1) == 1) {
                    try {
                        $sepas = CustomerSepa::factory(rand(1, 5))->create([
                            'amount' => -rand(5, 3500),
                            'customer_wallet_id' => $wallet->id,
                            'updated_at' => now()->addDays(rand(1, 5)),
                            'status' => 'waiting',
                        ]);
                    } catch (\Exception $exception) {
                        LogHelper::notify('critical', $exception);
                    }

                    foreach ($sepas as $sepa) {
                        try {
                            $creditor = CustomerCreditor::where('name', 'LIKE', '%'.$sepa->creditor.'%')->count();
                            if ($creditor == 0) {
                                CustomerCreditor::create([
                                    'name' => $sepa->creditor,
                                    'customer_wallet_id' => $wallet->id,
                                    'customer_sepa_id' => $sepa->id,
                                ]);
                            }
                        } catch (\Exception $exception) {
                            LogHelper::notify('critical', $exception);
                        }

                        if ($customer->setting->notif_mail == 1) {
                            $customer->user->notify(new NewPrlvPresented($sepa));
                        }
                    }
                }
            }
        }
    }

    private function generateMensualReleve()
    {
        $wallets = CustomerWallet::where('type', 'compte')->where('status', 'active')->get();
        $i = 0;

        foreach ($wallets as $wallet) {
            $file = DocumentFile::createDoc(
                $wallet->customer,
                'Relever Mensuel',
                'Relever Mensuel '.now()->monthName,
                2,
                null,
                false,
                false,
                false,
                true,
                [
                    'wallet' => $wallet,
                ]
            );

            $wallet->customer->user->notify(new GenerateMensualReleverNotification($file));
            $i++;
        }

        $this->info('Nombre de relevé généré: '.$i);
    }
}
