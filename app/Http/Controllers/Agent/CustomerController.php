<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerSituationHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Mail\Customer\WelcomeContract;
use App\Models\Core\DocumentCategory;
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
use App\Notifications\Customer\SendCodeCardNotification;
use Authy\AuthyApi;
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
        //dd($request->all());
        $user = $this->createUser($request);

        return response()->json($user);
    }

    public function show($customer_id)
    {
        $customer = Customer::with('user', 'package', 'info', 'setting', 'situation', 'income', 'charge', 'wallets', 'beneficiaires', 'documents', 'transmisses')->find($customer_id);

        return view('agent.customer.show', compact('customer'));
    }

    public function update(Request $request, $customer_id)
    {
        //dd($request->all());
        $customer = Customer::find($customer_id);
        switch ($request->get('control')) {
            case 'address':
                CustomerInfo::where('customer_id', $customer_id)->first()->update([
                    'address' => $request->get('address') ? $request->get('address') : $customer->info->address,
                    'addressbis' => $request->get('addressbis') ? $request->get('addressbis') : $customer->info->addressbis,
                    'postal' => $request->get('postal') ? $request->get('postal') : $customer->info->postal,
                    'city' => $request->get('city') != null ? $request->get('city') : $customer->info->city,
                    'country' => $request->get('country') != null ? $request->get('country') : $customer->info->country,
                ]);
                break;

            case 'coordonnee':

                $customer->user->update([
                    'email' => $request->get('email') && $customer->user->email !== $request->get('email') ? $request->get('email') : $customer->user->email,
                ]);

                $customer->info->update([
                    'phone' => $request->has('phone') && $customer->info->phone !== $request->get('phone') ? $request->get('phone') : $customer->info->phone,
                    'mobile' => $request->has('mobile') && $customer->info->mobile !== $request->get('mobile') ? $request->get('mobile') : $customer->info->mobile,
                ]);
                break;

            case 'situation':
                $customer->situation->update([
                    'legal_capacity' => $request->has('legal_capacity') && $customer->situation->legal_capacity !== $request->get('legal_capacity') ? $request->get('legal_capacity') : $customer->situation->legal_capacity,
                    'family_situation' => $request->has('family_situation') && $customer->situation->family_situation !== $request->get('family_situation') ? $request->get('family_situation') : $customer->situation->family_situation,
                    'logement' => $request->has('logement') && $customer->situation->logement !== $request->get('logement') ? $request->get('logement') : $customer->situation->logement,
                    'logement_at' => $request->has('logement_at') && $customer->situation->logement_at !== $request->get('logement_at') ? $request->get('logement_at') : $customer->situation->logement_at,
                    'child' => $request->has('child') && $customer->situation->child !== $request->get('child') ? $request->get('child') : $customer->situation->child,
                    'person_charged' => $request->has('person_charged') && $customer->situation->person_charged !== $request->get('person_charged') ? $request->get('person_charged') : $customer->situation->person_charged,
                    'pro_category' => $request->has('pro_category') && $customer->situation->pro_category !== $request->get('pro_category') ? $request->get('pro_category') : $customer->situation->pro_category,
                    'pro_profession' => $request->has('pro_profession') && $customer->situation->pro_profession !== $request->get('pro_profession') ? $request->get('pro_profession') : $customer->situation->pro_profession,
                ]);

                $customer->income->update([
                    'pro_incoming' => $request->has('pro_incoming') && $customer->income->pro_incoming !== $request->get('pro_incoming') ? $request->get('pro_incoming') : $customer->income->pro_incoming,
                    'patrimoine' => $request->has('patrimoine') && $customer->income->patrimoine !== $request->get('patrimoine') ? $request->get('patrimoine') : $customer->income->patrimoine,
                ]);

                $customer->charge->update([
                    'rent' => $request->has('rent') && $customer->charge->rent !== $request->get('rent') ? $request->get('rent') : $customer->charge->rent,
                    'divers' => $request->has('divers') && $customer->charge->divers !== $request->get('divers') ? $request->get('divers') : $customer->charge->divers,
                    'nb_credit' => $request->has('nb_credit') && $customer->charge->nb_credit !== $request->get('nb_credit') ? $request->get('nb_credit') : $customer->charge->nb_credit,
                    'credit' => $request->has('credit') && $customer->charge->credit !== $request->get('credit') ? $request->get('credit') : $customer->charge->credit,
                ]);
                break;

            case 'communication':
                $customer->setting->update([
                    'notif_sms' => $request->has('notif_sms') ? 1 : 0,
                    'notif_app' => $request->has('notif_app') ? 1 : 0,
                    'notif_mail' => $request->has('notif_mail') ? 1 : 0,
                ]);
                break;
        }

        // Notification Client

        // Notification Agent
        LogHelper::notify('notice', 'Mise à jours des informations du client: '.$customer->user->name);

        return redirect()->back()->with('success', 'Les informations du client ont été mise à jours.');
    }

    private function createUser($request)
    {
        $password = \Str::random(10);

        $user = User::create([
            'name' => $request->get('firstname').' '.$request->get('lastname'),
            'email' => $request->get('email'),
            'password' => \Hash::make($password),
            'identifiant' => UserHelper::generateID(),
            'agency_id' => $request->user()->agency_id,
        ]);

        $customer = $this->createCustomer($request, $user, $password);

        return $user;
    }

    private function createCustomer($request, $user, $password)
    {
        $code_auth = rand(1000, 9999);
        $customer = Customer::create([
            'status_open_account' => 'terminated',
            'auth_code' => base64_encode($code_auth),
            'user_id' => $user->id,
            'package_id' => $request->get('package_id'),
            'agency_id' => $user->agency_id,
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
            'country_code' => '+33',
            'customer_id' => $customer->id,
        ]);

        $authy = new AuthyApi(config('twilio-notification-channel.authy_secret'));
        $authyUser = $authy->registerUser($user->email, $request->get('mobile'), '+33');
        if ($authyUser->ok()) {
            $info->authy_id = $authyUser->id();
        } else {
            LogHelper::notify('critical', "Erreur d'authentification AUTHYID");
        }

        $info->save();

        $setting = CustomerSetting::create([
            'customer_id' => $customer->id,
        ]);

        $situation = CustomerSituation::create([
            'legal_capacity' => $request->get('legal_capacity'),
            'family_situation' => $request->get('family_situation'),
            'logement' => $request->get('logement'),
            'logement_at' => $request->get('logement_at'),
            'child' => $request->get('child'),
            'person_charged' => $request->get('person_charged'),
            'pro_category' => $request->get('pro_category'),
            'pro_profession' => $request->get('pro_profession'),
            'customer_id' => $customer->id,
        ]);

        $income = CustomerSituationIncome::create([
            'pro_incoming' => $request->get('pro_incoming'),
            'patrimoine' => $request->get('patrimoine'),
            'customer_id' => $customer->id,
        ]);

        $charge = CustomerSituationCharge::create([
            'rent' => $request->get('rent'),
            'nb_credit' => $request->get('nb_credit'),
            'credit' => $request->get('credit'),
            'divers' => $request->get('divers'),
            'customer_id' => $customer->id,
        ]);

        $wallet = $this->createWallet($customer);
        $card = $this->createCreditCard($request, $wallet);

        // Envoie du mot de passe provisoire par SMS avec identifiant
        $info->notify(new SendPasswordSms($password));

        \Storage::disk('public')->makeDirectory('gdd/'.$customer->id);
        foreach (DocumentCategory::all() as $doc) {
            \Storage::disk('public')->makeDirectory('gdd/'.$customer->id.'/'.$doc->id);
        }


        /*
         * Création des documents usuel du comptes
         * - Convention de preuve
         * - Certification Fiscal
         * - Synthese echange
         * - Contrat Banque à distance
         * - Contrat Banque Souscription
         * - RIB
         */

        DocumentFile::createDoc(
            $customer,
            'Convention Preuve',
            'Convention de Preuve - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        DocumentFile::createDoc(
            $customer,
            'Certification Fiscal',
            'Formulaire d\'auto-certification de résidence fiscale - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        DocumentFile::createDoc(
            $customer,
            'Synthese Echange',
            'Synthese Echange - CUS' . $customer->user->identifiant,
            3,
            null,
            false,
            false,
            false,
            true,
            ["card" => $card]);

        DocumentFile::createDoc(
            $customer,
            'Contrat Banque Distance',
            'Contrat Banque à distance - CUS' . $customer->user->identifiant,
            3,
            null,
            true,
            true,
            false,
            true,
            []);

        $document = DocumentFile::createDoc(
            $customer,
            'Contrat Banque Souscription',
            'Convention de compte - CUS' . $customer->user->identifiant,
            3,
            'CNT' . \Str::upper(\Str::random(6)),
            true,
            true,
            false,
            true,
            ["card" => $card, "wallet" => $wallet]);

        DocumentFile::createDoc(
            $customer,
            'Info Tarif',
            'Information Tarifaire',
            5,
            null,
            false,
            false,
            false,
            false,
            []);

        DocumentFile::createDoc(
            $customer,
            'Rib',
            'Relevé Identité Bancaire',
            5,
            null,
            false,
            false,
            false,
            false,
            ["wallet" => $wallet]);

        \Storage::disk('public')->copy('gdd/shared/info_tarif.pdf', 'gdd/'.$customer->id.'/5/info_tarif.pdf');

        // Notification mail de Bienvenue
        \Mail::to($user)->send(new WelcomeContract($customer, $document));

    }

    private function createWallet($customer)
    {
        $number_account = rand(10000000000, 99999999999);
        $ibanC = new Generator($customer->user->agency->code_banque, $number_account, 'FR');
        $iban = $ibanC->generate();
        $rib_key = \Str::substr($iban, 18, 2);

        return CustomerWallet::create([
            'uuid' => \Str::uuid(),
            'number_account' => $number_account,
            'iban' => $iban,
            'rib_key' => $rib_key,
            'type' => 'compte',
            'status' => 'active',
            'customer_id' => $customer->id,
        ]);
    }

    private function createCreditCard($request, $wallet)
    {
        $creditcard = new \Plansky\CreditCard\Generator();
        $card_number = $creditcard->single();
        $card_code = rand(1000, 9999);

        $card = CustomerCreditCard::create([
            'exp_month' => \Str::length(now()->month) <= 1 ? '0'.now()->month : now()->month,
            'number' => $card_number,
            'support' => $request->get('card_support'),
            'debit' => $request->get('card_debit'),
            'cvc' => rand(100, 999),
            'code' => base64_encode($card_code),
            'limit_payment' => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'limit_retrait' => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'customer_wallet_id' => $wallet->id,
        ]);

        // Envoie du code de la carte bleu par sms
        $card->wallet->customer->user->notify(new SendCodeCardNotification($card_code, $card));

        return $card;
    }
}
