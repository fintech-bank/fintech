<?php

namespace App\Console\Commands;

use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\UserHelper;
use App\Models\Core\DocumentCategory;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
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
    protected $signature = 'life {call}';

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
        switch ($this->argument('call')) {
            case 'generateCustomer':
                return $this->generateCustomer();
                break;
        }
    }

    private function generateCustomer()
    {
        $nb = rand(0,5);

        $users = User::factory($nb)->create([
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 2
        ]);

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
                $account = CustomerWallet::factory()->create([
                    'type' => 'compte',
                    'customer_id' => $customer->id
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

                CustomerBeneficiaire::factory(rand(1,10))->create([
                    "customer_id" => $customer->id,
                ]);

                $card = CustomerCreditCard::factory()->create([
                    "customer_wallet_id" => $account->id
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
                    ["card" => $card]
                );

                foreach (CustomerCreditCard::query()->where('facelia', 1)->get() as $card) {
                    $amount = [500,1000,1500,2000,2500,3000];
                    $amount_loan = $amount[rand(0,5)];
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
                        $pr->reference." - Plan d'amortissement",
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
                        $pr->reference." - Assurance Emprunteur",
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
                        $pr->reference." - Avis de conseil Relatif au assurance emprunteur",
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
                        $pr->reference." - Contrat de Crédit FACELIA",
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
                        $pr->reference." - Fiche de Dialogue",
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
                        $pr->reference." - Information Précontractuel Normalisé",
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
                        $pr->reference." - Mandat Prélèvement SEPA",
                        3,
                        null,
                        false,
                        false,
                        false,
                        true,
                        ["loan" => $pr]
                    );
                }
            }
        }

        $this->line("Nombre de nouveau client: ".$nb);
        return null;
    }
}
