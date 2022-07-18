<?php

namespace App\Console\Commands;

use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\UserHelper;
use App\Models\Core\Agency;
use App\Models\Core\DocumentCategory;
use App\Models\Core\EpargnePlan;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use Carbon\Carbon;
use IbanGenerator\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SystemSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:seed {--base} {--test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed System';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('base')) {
            $this->call('migrate:fresh');
        }

        $this->info("Seeding: Liste des agences");
        $this->call("db:seed", ["class" => "AgencySeeder"]);

        $this->info("Seeding: Liste des Banques");
        $this->call("db:seed", ["class" => "BanksTableSeeder"]);

        $this->info("Seeding: Liste des Plan d'épargne");
        $this->call("db:seed", ["class" => "EpargnePlanSeeder"]);

        $this->info("Seeding: Liste des Plan de Pret");
        $this->call("db:seed", ["class" => "LoanPlanSeeder"]);

        $this->info("Seeding: Liste des Interets des plan de pret");
        $this->call("db:seed", ["class" => "LoanPlanInterestSeeder"]);

        $this->info("Seeding: Liste des Packages");
        $this->call("db:seed", ["class" => "PackageSeeder"]);

        $this->info("Seeding: Liste des Services");
        $this->call("db:seed", ["class" => "ServiceSeeder"]);

        $this->info("Seeding: Liste des Utilisateur de Test");
        $this->call("db:seed", ["class" => "UserSeeder"]);

        $this->info("Seeding: Liste des Catégories de documents");
        $this->call("db:seed", ["class" => "DocumentCategorySeeder"]);

        $this->info("Seeding: Liste des Catégories de pages");
        $this->call("db:seed", ["class" => "CmsCategorySeeder"]);

        $this->info("Seeding: Liste des Sous Catégories de pages");
        $this->call("db:seed", ["class" => "CmsSubCategorySeeder"]);

        if ($this->option('test')) {
            $this->info("Seeding TESTING: Création de la base client");
            $this->createCustomer();
        }
        return 0;
    }

    private function createCustomer()
    {
        $agency = Agency::all()->random();


        $users = User::factory(rand(100, 200))->create([
            "admin" => false,
            "agent" => false,
            "customer" => true,
            "identifiant" => UserHelper::generateID(),
            "agency_id" => $agency->id,
        ]);

        $bar = $this->output->createProgressBar(User::all()->count());
        $bar->start();

        foreach ($users as $user) {
            $customer = Customer::factory()->create([
                'user_id' => $user->id,
                "package_id" => Package::all()->random()->id,
                "agent_id" => 2
            ]);

            \Storage::disk('public')->makeDirectory('gdd/' . $customer->id);
            foreach (DocumentCategory::all() as $doc) {
                \Storage::disk('public')->makeDirectory('gdd/' . $customer->id . '/' . $doc->id);
            }

            CustomerInfo::factory()->create([
                "customer_id" => $customer->id,
            ]);

            $user->update([
                'name' => CustomerHelper::getName($customer, true)
            ]);

            CustomerSetting::factory()->create([
                "customer_id" => $customer->id,
            ]);

            CustomerSituation::factory()->create([
                "customer_id" => $customer->id
            ]);

            CustomerSituationCharge::factory()->create([
                'customer_id' => $customer->id,
            ]);

            CustomerSituationIncome::factory()->create([
                "customer_id" => $customer->id,
            ]);


            if ($customer->status_open_account == 'terminated') {
                $epargne = rand(0, 1);
                $pret = rand(0, 1);
                $nb_epargne = rand(1, 2);
                $nb_pret = rand(1, 5);

                // Wallet Account
                $wallet_account = CustomerWallet::factory()->create([
                    "type" => "compte",
                    "customer_id" => $customer->id,
                    'balance_actual' => 0,
                    'balance_coming' => 0
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
                    ['wallet' => $wallet_account]);


                if ($epargne == 1) {
                    $wallet_epargnes = CustomerWallet::factory($nb_epargne)->create([
                        'type' => 'epargne',
                        "customer_id" => $customer->id,
                        "decouvert" => false,
                        "balance_decouvert" => 0
                    ]);

                    foreach ($wallet_epargnes as $wallet_epargne) {
                        CustomerEpargne::factory()->create([
                            'wallet_id' => $wallet_epargne->id,
                            "wallet_payment_id" => $wallet_account->id,
                            "epargne_plan_id" => EpargnePlan::all()->random()->id,
                        ]);

                        if ($wallet_epargne->customer->info->type == 'part') {
                            CustomerBeneficiaire::query()->create([
                                'uuid' => Str::uuid(),
                                'type' => 'retail',
                                'civility' => Str::upper($wallet_epargne->customer->info->civility),
                                'firstname' => $wallet_epargne->customer->info->firstname,
                                'lastname' => $wallet_epargne->customer->info->lastname,
                                'currency' => 'eur',
                                'bankname' => 'Finbank',
                                'iban' => $wallet_epargne->iban,
                                'bic' => $wallet_epargne->customer->user->agency->bic,
                                'titulaire' => true,
                                'customer_id' => $customer->id,
                                'bank_id' => 176
                            ]);
                        } else {
                            CustomerBeneficiaire::query()->create([
                                'uuid' => Str::uuid(),
                                'type' => 'corporate',
                                'company' => $wallet_epargne->customer->info->company,
                                'currency' => 'eur',
                                'bankname' => 'Finbank',
                                'iban' => $wallet_epargne->iban,
                                'bic' => $wallet_epargne->customer->user->agency->bic,
                                'titulaire' => true,
                                'customer_id' => $customer->id,
                                'bank_id' => 176
                            ]);
                        }

                    }
                }

                if ($pret == 1) {
                    $wallet_prets = CustomerWallet::factory($nb_pret)->create([
                        'type' => "pret",
                        "customer_id" => $customer->id,
                        "decouvert" => false,
                        "balance_decouvert" => 0
                    ]);

                    foreach ($wallet_prets as $wallet_pret) {
                        CustomerPret::factory()->create([
                            'customer_wallet_id' => $wallet_pret->id,
                            "wallet_payment_id" => $wallet_account->id,
                            "customer_id" => $customer->id
                        ]);
                    }
                }

                // Bénéficiaire
                CustomerBeneficiaire::factory(rand(1, 10))->create([
                    "customer_id" => $customer->id,
                ]);

                //dd(CustomerBeneficiaire::query()->where('customer_id', $customer->id)->get()->random());

                // Commande de chéquier
                CustomerCheck::factory(rand(0, 2))->create([
                    "customer_wallet_id" => $wallet_account->id
                ]);

                // Carte Bancaire Physique
                $card = CustomerCreditCard::factory()->create([
                    "customer_wallet_id" => $wallet_account->id,
                    'status' => 'active'
                ]);

                if ($card->support == 'premium' || $card->support == 'infinite') {
                    $card->update([
                        'facelia' => rand(0, 1)
                    ]);
                }

                DocumentFile::createDoc(
                    $customer,
                    'convention cb physique',
                    'Convention CB Visa Physique',
                    3,
                    null,
                    true,
                    true,
                    false,
                    true,
                    ['wallet' => $wallet_account, 'card' => $card]
                );

                if ($card->facelia == 1) {
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
                        'customer_id' => $customer->id
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
                        'customer_id' => $customer->id
                    ]);

                    $card->update([
                        'customer_pret_id' => $pr->id
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
                        'wallet_payment_id' => $card->wallet->id
                    ]);

                    DocumentFile::createDoc(
                        $customer,
                        'Plan d\'amortissement',
                        $pr->reference . " - Plan d'amortissement",
                        3,
                        null,
                        false,
                        false,
                        false,
                        true,
                        ["loan" => $pr]
                    );

                    DocumentFile::createDoc(
                        $customer,
                        'Assurance Emprunteur',
                        $pr->reference . " - Assurance Emprunteur",
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
                        "Avis de conseil relatif assurance",
                        $pr->reference . " - Avis de conseil Relatif au assurance emprunteur",
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
                        $pr->reference . " - Contrat de Crédit FACELIA",
                        3,
                        null,
                        true,
                        true,
                        false,
                        true,
                        ["loan" => $pr]
                    );

                    DocumentFile::createDoc(
                        $customer,
                        'Fiche de dialogue',
                        $pr->reference . " - Fiche de Dialogue",
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
                        $pr->reference . " - Information Précontractuel Normalisé",
                        3,
                        null,
                        true,
                        true,
                        false,
                        true,
                        ["loan" => $pr]
                    );

                    DocumentFile::createDoc(
                        $customer,
                        'Mandat Prélevement sepa',
                        $pr->reference . " - Mandat Prélèvement SEPA",
                        3,
                        null,
                        false,
                        false,
                        false,
                        true,
                        ["loan" => $pr]
                    );
                }

                $transactionsSepa = CustomerTransaction::where('type', 'sepa')->where('customer_wallet_id', $wallet_account->id)->get();
                $transactionsSepaTransfers = CustomerTransaction::where('type', 'virement')->where('customer_wallet_id', $wallet_account->id)->get();

                foreach ($transactionsSepa as $sepa) {
                    $s = CustomerSepa::factory()->create([
                        "amount" => $sepa->amount,
                        "customer_wallet_id" => $wallet_account->id,
                    ]);

                    if (CustomerCreditor::where('name', $s->creditor)->where('customer_wallet_id', $wallet_account->id)->count() == 0) {
                        CustomerCreditor::query()->create([
                            'name' => $s->creditor,
                            'customer_wallet_id' => $s->customer_wallet_id,
                            'customer_sepa_id' => $s->id
                        ]);
                    }
                }

                foreach (CustomerCreditCard::query()->where('facelia', 1)->get() as $card) {
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
                        'customer_id' => $customer->id
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
                        'customer_id' => $customer->id
                    ]);

                    $card->update([
                        'customer_pret_id' => $pr->id
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
                        'wallet_payment_id' => $card->wallet->id
                    ]);
                }

                $this->generateTransactions(rand(10, 100), $wallet_account);

            }


            $bar->advance();
        }

        $bar->finish();
    }

    private function generateTransactions($nb_max, $wallet)
    {
        for ($i = 0; $i <= $nb_max; $i++) {
            $type = rand(0, 1) == 0 ? 'debit' : 'credit';
            $transpac = ['depot', 'retrait', 'payment', 'virement', 'sepa', 'frais', 'souscription', 'autre'];
            $transpac_choice = $transpac[rand(0, 7)];
            $confirm = rand(0, 1);
            $card = $transpac_choice == 'payment' || $transpac_choice == 'retrait' || $transpac_choice == 'depot' ? $wallet->cards()->where('status', 'active')->first() : null;
            $amount = $this->amount($transpac_choice, $wallet);


            if ($transpac_choice == 'retrait') {
                if (\App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card, true) < 100 && $amount < \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card)) {
                    CustomerTransactionHelper::create(
                        $type,
                        $transpac_choice,
                        $this->choiceDescription($transpac_choice),
                        $amount,
                        $wallet->id,
                        $confirm == 1 ? true : false,
                        $this->choiceDescription($transpac_choice),
                        $confirm == 1 ? now() : null, now(), $card->id);
                }
            } elseif ($transpac_choice == 'payment') {
                if (\App\Helper\CustomerCreditCard::getTransactionsMonthPayment($card, true) < 100 && $amount < \App\Helper\CustomerCreditCard::getTransactionsMonthPayment($card)) {
                    CustomerTransactionHelper::create(
                        $type,
                        $transpac_choice,
                        $this->choiceDescription($transpac_choice),
                        $amount,
                        $wallet->id,
                        $confirm == 1 ? true : false,
                        $this->choiceDescription($transpac_choice),
                        $confirm == 1 ? now() : null, now(), $card->id);
                }
            } elseif($transpac_choice == 'depot') {
                CustomerTransactionHelper::create(
                    $type,
                    $transpac_choice,
                    $this->choiceDescription($transpac_choice),
                    $amount,
                    $wallet->id,
                    $confirm == 1 ? true : false,
                    $this->choiceDescription($transpac_choice),
                    $confirm == 1 ? now() : null, now(), $card->id);
            } else {
                CustomerTransactionHelper::create(
                    $type,
                    $transpac_choice,
                    $this->choiceDescription($transpac_choice),
                    $amount,
                    $wallet->id,
                    $confirm == 1 ? true : false,
                    $this->choiceDescription($transpac_choice),
                    $confirm == 1 ? now() : null, now());
            }
        }
    }

    private function choiceDescription($type_choice)
    {
        switch ($type_choice) {
            case 'depot':
                return "Dépot d'argent sur votre compte";
                break;

            case 'retrait':
                return "Retrait d'argent sur votre compte";
                break;

            case 'payment':
                return "Payment CB Ref:" . Str::upper(Str::random(8));
                break;

            case 'virement':
                return "Virement bancaire sur votre compte";
                break;

            case 'sepa':
                return "Prélèvement SEPA sur votre compte";
                break;

            case 'frais':
                return "Frais Bancaire";
                break;

            case 'souscription':
                return "Cotisation bancaire";
                break;

            default:
                return "Autre Mouvement bancaire";
                break;
        }
    }

    private function amount($choice, $wallet)
    {
        switch ($choice) {
            case 'depot':
                return rand(100, 9000);
                break;

            case 'retrait':
                return -rand(1000, $wallet->cards()->first()->limit_retrait);
                break;

            case 'payment':
                return -rand(1, $wallet->cards()->first()->limit_payment);
                break;

            case 'virement':
                if (rand(0, 1) == 0) {
                    return -rand(10, 90000);
                } else {
                    return rand(10, 90000);
                }
                break;

            case 'sepa':
                return -rand(10, 90000);
                break;

            case 'frais':
                return -rand(10, 99) / 10;
                break;

            case 'souscription':
                $ar = [0, 4.99, 9.99];
                return $ar[rand(0, 2)];
                break;

            default:
                if (rand(0, 1) == 0) {
                    return -rand(1, 9000);
                } else {
                    return rand(1, 9000);
                }
                break;
        }
    }
}
