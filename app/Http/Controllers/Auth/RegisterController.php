<?php

namespace App\Http\Controllers\Auth;

use App\Helper\CustomerSituationHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Mail\Customer\WelcomeContract;
use App\Models\Core\DocumentCategory;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use App\Notifications\Core\SendPasswordSms;
use App\Notifications\Customer\SendCodeCardNotification;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Services\BankFintech;
use App\Services\Ovh;
use App\Services\Stripe;
use Authy\AuthyApi;
use IbanGenerator\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    public function cart(Request $request)
    {
        $package = Package::find($request->get('package'));
        session()->put('package', $package);

        return view('auth.cart', compact('package'));
    }

    public function card(Request $request)
    {
        return view('auth.card', [
            'package' => session()->get('package'),
        ]);
    }

    public function persoHome(Request $request)
    {
        session()->put('cart', ['type' => $request->get('support'), 'debit' => $request->get('debit')]);

        return view('auth.perso_home');
    }

    public function persoPro(Request $request)
    {
        session()->put('personal', $request->except('_token'));

        return view('auth.perso_pro');
    }

    public function persoFinal(Request $request)
    {
        session()->put('pro', $request->except('_token'));

        //dd(session()->all());

        return view('auth.perso_final', [
            'personal' => session('personal'),
            'cart' => session('cart'),
            'package' => session('package'),
            'pro' => session('pro'),
            'limit_payment' => round((session('pro.pro_incoming') + session('pro.patrimoine') - (session('pro.rent') + session('pro.divers') + session('pro.credit'))) * 1.9, -2),
            'limit_retrait' => round((session('pro.pro_incoming') + session('pro.patrimoine') - (session('pro.rent') + session('pro.divers') + session('pro.credit'))) / 1.9, -2),
        ]);
    }

    public function signateInit(Request $request)
    {
        //dd(session()->all());
        $user = $this->createUser($request->session()->get('personal'));

        session()->put('user', $user);

        return redirect()->route('register.signate-sign', ['user' => $user]);
    }

    public function signateSign(Request $request)
    {
        $user = User::find($request->get('user'));

        return view('auth.signate', [
            'user' => $user,
            'documents' => $user->customers->documents()->where('document_category_id', 3)->where('signable', 1)->get(),
        ]);
    }

    public function signate(Request $request)
    {
        $document = CustomerDocument::find($request->get('document'));

        try {
            $document->update([
                'signed_by_client' => 1,
                'signed_at' => now(),
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json([
                'errors' => [$exception->getMessage()],
            ], 500);
        }
    }

    public function identityInit(Request $request, Stripe $stripe)
    {
        $session = $stripe->client->identity->verificationSessions->create([
            'type' => 'document',
            'metadata' => [
                'user' => session('user'),
            ],
        ]);

        return view('auth.identity_init', [
            'user' => session('user'),
            'client_secret' => $session->client_secret,
        ]);
    }

    public function terminate(Request $request, Stripe $stripe)
    {
        $ses = session('user.id');
        $user = User::find($ses);

        $user->customers->info->update([
            'isVerified' => 1,
        ]);

        if ($request->has('payment') && $request->get('payment') == 'success') {
            $user->customers->update([
                'status_open_account' => 'completed',
            ]);

            $wallet = $user->customers->wallets()->first();
            $transaction = CustomerTransactionHelper::create('credit', 'depot', 'Dépot initial', 20, $wallet->id,
                true, "Dépot initial à l'ouverture de votre compte", now(), null, null);
            LogHelper::notify('info', "
            Un dépot d'ouverture de compte à été effectuer:<br>
            Nom: $user->name<br>
            Montant: 20,00 €<br>
            Identifiant Customer: $user->customers->id
            ");

            $user->notify(new UpdateStatusAccountNotification($user->customers, $user->customers->status_open_account));

            return view('auth.terminate', [
                'user' => $user,
            ]);
        } else {
            try {
                $intent = $stripe->client->paymentIntents->create([
                    'amount' => 2000,
                    'currency' => 'eur',
                    'payment_method_types' => [
                        'card',
                        'sepa_debit',
                    ],
                ]);

                return view('auth.terminate', [
                    'user' => $user,
                    'client_secret' => $intent->client_secret,
                ]);
            } catch (\Error $error) {
                LogHelper::notify('critical', $error->getMessage());
                dd($error);
            }
        }
    }

    private function createUser($request)
    {
        $password = \Str::random(10);

        $user = User::create([
            'name' => $request['firstname'] . ' ' . $request['lastname'],
            'email' => $request['email'],
            'password' => \Hash::make($password),
            'identifiant' => UserHelper::generateID(),
            'agency_id' => 1,
        ]);

        $customer = $this->createCustomer(session(), $user, $password);

        return $user;
    }

    private function createCustomer($request, $user, $password)
    {
        $package = (object)$request->get('package');
        $card = (object)$request->get('cart');
        $pro = (object)$request->get('pro');
        $personal = (object)$request->get('personal');
        $code_auth = rand(1000, 9999);
        $bank = new BankFintech();
        $ficp = $bank->callInter();
        $ovh = new Ovh();

        $customer = Customer::create([
            'status_open_account' => 'open',
            'auth_code' => base64_encode($code_auth),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'agency_id' => $user->agency_id,
            'ficp' => $ficp->ficp ? 1 : 0,
            'fcc' => $ficp->fcc ? 1 : 0,
        ]);

        $info = CustomerInfo::create([
            'type' => 'part',
            'civility' => $personal->civility,
            'lastname' => $personal->lastname,
            'middlename' => $personal->middlename,
            'firstname' => $personal->firstname,
            'datebirth' => Carbon::createFromTimestamp(strtotime($personal->datebirth)),
            'citybirth' => $personal->citybirth,
            'countrybirth' => $personal->countrybirth,
            'address' => $personal->address,
            'addressbis' => $personal->addressbis,
            'postal' => $personal->postal,
            'city' => $personal->city,
            'country' => $personal->country,
            'phone' => $personal->phone,
            'mobile' => $personal->mobile,
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
            'legal_capacity' => $pro->legal_capacity,
            'family_situation' => $pro->family_situation,
            'logement' => $pro->logement,
            'logement_at' => $pro->logement_at,
            'child' => $pro->child,
            'person_charged' => $pro->person_charged,
            'pro_category' => $pro->pro_category,
            'pro_profession' => $pro->pro_profession,
            'customer_id' => $customer->id,
        ]);

        $income = CustomerSituationIncome::create([
            'pro_incoming' => $pro->pro_incoming,
            'patrimoine' => $pro->patrimoine,
            'customer_id' => $customer->id,
        ]);

        $charge = CustomerSituationCharge::create([
            'rent' => $pro->rent,
            'nb_credit' => $pro->nb_credit,
            'credit' => $pro->credit,
            'divers' => $pro->divers,
            'customer_id' => $customer->id,
        ]);

        $wallet = $this->createWallet($customer);
        $card = $this->createCreditCard($card, $wallet);

        switch ($package->name) {
            case 'Cristal':
                $setting->update([
                    'nb_physical_card' => 1,
                    'nb_virtual_card' => 0,
                    'check' => 0,
                ]);
                break;

            case 'Gold':
                $setting->update([
                    'nb_physical_card' => 1,
                    'nb_virtual_card' => 5,
                    'check' => 1,
                ]);
                break;

            case 'Platine':
                $setting->update([
                    'nb_physical_card' => 5,
                    'nb_virtual_card' => 5,
                    'check' => 1,
                ]);

                $this->calcultateFacility($pro->pro_incoming, $customer, $wallet);
                $this->defineDifferedAmount($pro->pro_incoming, $customer, $card);

        }

        // Envoie du mot de passe provisoire par SMS avec identifiant
        try {
            $info->notify(new SendPasswordSms($password));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
        }

        \Storage::disk('public')->makeDirectory('gdd/' . $customer->id);
        foreach (DocumentCategory::all() as $doc) {
            \Storage::disk('public')->makeDirectory('gdd/' . $customer->id . '/' . $doc->id);
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

    private function createCreditCard($request, CustomerWallet $wallet)
    {
        $ovh = new Ovh();
        $creditcard = new \Plansky\CreditCard\Generator();
        $card_number = $creditcard->single();
        $card_code = rand(1000, 9999);

        $card = \App\Models\Customer\CustomerCreditCard::create([
            'exp_month' => \Str::length(now()->month) <= 1 ? '0' . now()->month : now()->month,
            'number' => $card_number,
            'support' => $request->type,
            'debit' => $request->debit ? $request->debit : 'immediate',
            'cvc' => rand(100, 999),
            'code' => base64_encode($card_code),
            'limit_payment' => \App\Helper\CustomerCreditCard::calcLimitPayment(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'limit_retrait' => \App\Helper\CustomerCreditCard::calcLimitRetrait(CustomerSituationHelper::calcDiffInSituation($wallet->customer)),
            'customer_wallet_id' => $wallet->id,
        ]);

        // Envoie du code de la carte bleu par sms
        $wallet->customer->info->notify(new SendCodeCardNotification($card_code, $card));

        return $card;
    }

    private function calcultateFacility($incoming, Customer $customer, CustomerWallet $wallet)
    {
        $calc = $incoming / 3;
        if ($customer->ficp == 0) {
            if ($calc >= 300) {
                $result = $calc > 1000 ? 1000 : ceil($calc / 100) * 100;
                $wallet->update([
                    'decouvert' => 1,
                    'balance_decouvert' => $result,
                ]);
            }
        }
    }

    private function defineDifferedAmount($incoming, Customer $customer, \App\Models\Customer\CustomerCreditCard $card)
    {
        $calc = $incoming / 1.8;
        if ($customer->ficp == 0) {
            if ($calc >= 300) {
                $result = $calc > 10000 ? 10000 : ceil($calc / 100) * 100;
                $card->update([
                    'differed_limit' => $result,
                ]);
            }
        }
    }
}
