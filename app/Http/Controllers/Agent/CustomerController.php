<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerSituationHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use App\Notifications\Core\SendPasswordSms;
use IbanGenerator\Generator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('agent.customer.index');
    }

    public function create()
    {
        return view('agent.customer.create');
    }

    public function store(Request $request)
    {
        $user = $this->createUser($request);

        return response()->json($user);
    }

    private function createUser($request)
    {
        $password = \Str::random(10);

        $user = User::create([
            "name" => $request->get('firstname')." ".$request->get('lastname'),
            "email" => $request->get('email'),
            "password" => \Hash::make($password),
            "identifiant" => UserHelper::generateID(),
            "agency_id" => $request->user()->agency_id
        ]);

        $customer = $this->createCustomer($request, $user, $password);

        return $user;
    }

    private function createCustomer($request, $user, $password)
    {
        $code_auth = rand(1000,9999);
        $customer = Customer::create([
            'status_open_account' => "terminated",
            'auth_code' => $code_auth,
            'user_id' => $user->id,
            'package_id' => $request->get('package_id'),
            'agency_id' => $user->agency_id
        ]);

        $info = CustomerInfo::create([
            'type' => $request->get('type'),
            'civility' => $request->get('civility'),
            'lastname' => $request->get('lastname'),
            'middlename' => $request->get('middlename'),
            'firstname' => $request->get('firstname'),
            'datebirth' => $request->get('datebirth'),
            'citybirth' => $request->get('citybirth'),
            'countrybirth' => $request->get('countrybirth'),
            'company' => $request->get('company'),
            'siret' => $request->get('siret'),
            'address' => $request->get('address'),
            'addressbis' => $request->get('addressbis'),
            'postal' => $request->get('postal'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'phone' => $request->get('phone'),
            'mobile' => $request->get('mobile'),
            'customer_id' => $customer->id
        ]);

        $setting = CustomerSetting::create([
            'customer_id' => $customer->id
        ]);

        $situation = CustomerSituation::create([
            "legal_capacity" => $request->get('legal_capacity'),
            "family_situation" => $request->get('family_situation'),
            "logement" => $request->get('logement'),
            "logement_at" => $request->get('logement_at'),
            "child" => $request->get('child'),
            "person_charged" => $request->get('person_charged'),
            "pro_category" => $request->get('pro_category'),
            "pro_profession" => $request->get('pro_profession'),
            "customer_id" => $customer->id
        ]);

        $income = CustomerSituationIncome::create([
            "pro_incoming" => $request->get('pro_incoming'),
            "patrimoine" => $request->get('patrimoine'),
            "customer_id" => $customer->id
        ]);

        $charge = CustomerSituationCharge::create([
            "rent" => $request->get('rent'),
            "nb_credit" => $request->get('nb_credit'),
            "credit" => $request->get('credit'),
            "divers" => $request->get('divers'),
            "customer_id" => $customer->id
        ]);

        $wallet = $this->createWallet($customer);
        $this->createCreditCard($request, $wallet);

        // Envoie du mot de passe provisoire par SMS avec identifiant
        $info->notify(new SendPasswordSms($user, $password));

        /*
         * Création des documents usuel du comptes
         * - Convention
         * - RIB
         * - Convention Carte Bleu
         * - Condition Générale
         */

        // Notification mail de Bienvenue
    }

    private function createWallet($customer)
    {
        $number_account = rand(1000000000,9999999999).\Str::upper(\Str::random(1));
        $ibanC = new Generator($customer->user->agency->code_banque, $number_account, 'FR');
        $iban = $ibanC->generate();
        $rib_key = \Str::substr($iban, 18,2);
        return CustomerWallet::create([
            "uuid" => \Str::uuid(),
            "number_account" => $number_account,
            'iban' => $iban,
            'rib_key' => $rib_key,
            'type' => 'compte',
            'status' => 'active',
            'customer_id' => $customer->id
        ]);
    }

    private function createCreditCard($request, $wallet)
    {
        $creditcard = new \Plansky\CreditCard\Generator();
        $card_number =$creditcard->single();
        $card_code = rand(1000,9999);

        return CustomerCreditCard::create([
            "exp_month" => \Str::length(now()->month) <= 1 ? "0".now()->month : now()->month,
            "number" => $card_number,
            "support" => $request->get('card_support'),
            "debit" => $request->get('card_debit'),
            "cvc" => rand(100,999),
            "code" => base64_encode($card_code),
            "limit_payment" => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            "limit_retrait" => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            "customer_wallet_id" => $wallet->customer_id
        ]);

        // Envoie du code de la carte bleu par sms
    }
}
