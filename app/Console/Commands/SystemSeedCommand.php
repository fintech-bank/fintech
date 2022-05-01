<?php

namespace App\Console\Commands;

use App\Helper\UserHelper;
use App\Models\Core\Agency;
use App\Models\Core\EpargnePlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerEpargne;
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
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SystemSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:seed {--test}';

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

        $users = User::factory(rand(20, 100))->create([
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

            CustomerInfo::factory()->create([
                "customer_id" => $customer->id,
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


            if($customer->status_open_account == 'terminated') {
                $epargne = rand(0,1);
                $pret = rand(0,1);
                $nb_epargne = rand(1,2);
                $nb_pret = rand(1,5);

                // Wallet Account
                $wallet_account = CustomerWallet::factory()->create([
                    "type" => "compte",
                    "customer_id" => $customer->id,
                ]);

                if($epargne == 1) {
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
                    }
                }

                if($pret == 1) {
                    $wallet_prets = CustomerWallet::factory($nb_pret)->create([
                        'type' => "pret",
                        "customer_id" => $customer->id,
                        "decouvert" => false,
                        "balance_decouvert" => 0
                    ]);

                    foreach ($wallet_prets as $wallet_pret) {
                        CustomerPret::factory()->create([
                            'wallet_loan_id' => $wallet_pret->id,
                            "wallet_payment_id" => $wallet_account->id,
                            "customer_id" => $customer->id
                        ]);
                    }
                }

                // Bénéficiaire
                CustomerBeneficiaire::factory(rand(1,10))->create([
                    "customer_id" => $customer->id,
                ]);

                // Commande de chéquier
                CustomerCheck::factory(rand(0,2))->create([
                    "customer_wallet_id" => $wallet_account->id
                ]);

                // Carte Bancaire Physique
                CustomerCreditCard::factory(rand(1,3))->create([
                    "customer_wallet_id" => $wallet_account->id
                ]);

                CustomerTransaction::factory(rand(5,100))->create([
                    'customer_wallet_id' => $wallet_account->id,
                ]);

                $transactionsSepa = CustomerTransaction::where('type', 'sepa')->where('customer_wallet_id', $wallet_account->id)->get();
                $transactionsSepaTransfers = CustomerTransaction::where('type', 'virement')->where('customer_wallet_id', $wallet_account->id)->get();

                foreach ($transactionsSepa as $sepa) {
                    CustomerSepa::factory()->create([
                        "amount" => $sepa->amount,
                        "customer_wallet_id" => $wallet_account->id,
                    ]);
                }

            }


            $bar->advance();
        }

        $bar->finish();
    }
}
