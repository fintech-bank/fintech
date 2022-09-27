<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\CustomerMobilityHelper;
use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Mail\Agent\Customer\WriteMail;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerMobility;
use App\Notifications\Agent\Customer\ReinitAuthCustomer;
use App\Notifications\Agent\Customer\ReinitCodeCustomer;
use App\Notifications\Agent\Customer\ReinitPasswordCustomer;
use App\Notifications\Agent\Customer\UpdateStatusAccountNotification;
use App\Notifications\Agent\Customer\UpdateTypeAccountNotification;
use App\Notifications\Customer\PhoneVerificationNotification;
use App\Services\Twillo;
use Illuminate\Http\Request;
use Twilio\Exceptions\TwilioException;

class CustomerController extends Controller
{
    public function info(Request $request)
    {
        switch ($request->get('call')) {
            case 'countAllCustomer':
                return response()->json(Customer::all()->count());
                break;

            case 'countAllVerifiedCustomer':
                return response()->json(CustomerInfo::where('isVerified', true)->get()->count());
                break;
        }
    }

    public function get($customer_id)
    {
        $customer = Customer::find($customer_id);

        $wallets = $customer->wallets()->where('type', 'compte')->where('status', 'active')->get();


        return response()->json([
            "customer" => $customer,
            "wallets" => $wallets
        ]);
    }

    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if ($wallet->balance_actual < 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'outdated',
                ];
            } else {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'ok',
                ];
            }
        }

        return $wallets;
    }

    public function updateStatus(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);

        if ($request->get('status_open_account') == 'closed') {
            $document = $documentFile->createDocument('Cloture du compte', $customer, 5, null, false, false, false, null, false);
            $documentFile->generatePDF(
                'agence.account_close',
                $customer,
                $document->id,
                [],
                false,
                true,
                '/storage/gdd/' . $customer_id . '/courriers/', false, 'address');
        }

        try {
            $customer->status_open_account = $request->get('status_open_account');
            $customer->save();

            // Notification Agent
            auth()->user()->notify(new UpdateStatusAccountNotification($customer, $request->get('status_open_account')));

            // Notification Client
            $customer->user->notify(new \App\Notifications\Customer\UpdateStatusAccountNotification($customer, $request->get('status_open_account'), null, 'Cloture du compte - CUS' . $customer->user->identifiant . '.pdf'));

            // response
            LogHelper::notify('notice', 'Mise à jour du status du compte client: ' . CustomerHelper::getName($customer));

            return response()->json([
                'status' => CustomerHelper::getStatusOpenAccount($request->get('status_open_account')),
            ]);
        } catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());

            return response()->json();
        }
    }

    public function updateTypeAccount(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);
        try {
            if ($customer->package_id != $request->get('package_id')) {
                $customer->package_id = $request->get('package_id');
                $customer->save();
                $package = Package::find($request->get('package_id'));

                $document = $documentFile->createDocument('Avenant Contrat Particulier', $customer, 3, null, true, true, true, now(), true, 'agence.convention_part');

                // Notification Agent
                auth()->user()->notify(new UpdateTypeAccountNotification($customer, $package));

                // Notification Client
                $customer->user->notify(new \App\Notifications\Customer\UpdateTypeAccountNotification($customer, $package));
            }

            return response()->json();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function writeSms(Request $request, $customer_id, Twillo $twillo)
    {
        $customer = Customer::find($customer_id);

        try {
            $twillo->client->messages->create($customer->info->mobile, [
                'body' => $request->get('message'),
                'from' => config('twilio-notification-channel.from'),
            ]);

            LogHelper::notify('notice', "Envoie d'un message sms au " . $customer->info->mobile);

            return response()->json();
        } catch (TwilioException $exception) {
            LogHelper::notify('error', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    public function writeMail(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        try {
            \Mail::to($customer->user->email)->send(new WriteMail($customer, $request->get('message')));

            LogHelper::notify('notice', "Envoie d'un message mail à " . $customer->user->email);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    public function reinitPass(Request $request, $customer_id)
    {
        $password = \Str::random(8);
        $customer = Customer::find($customer_id);

        try {
            $customer->user()->update([
                'password' => \Hash::make($password),
            ]);

            // Envoie du pass par sms
            try {
                if (config('app.env') == 'local') {
                    $customer->user->notify(new ReinitPasswordCustomer($password));
                } else {
                    $customer->info->notify(new ReinitPasswordCustomer($password));
                }
            } catch (\Exception $exception) {
                LogHelper::notify('error', $exception->getMessage());

                return response()->json($exception->getMessage(), 500);
            }
        } catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());

            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($password);
    }

    public function reinitCode(Request $request, $customer_id)
    {
        $code = random_numeric(4);
        $customer = Customer::find($customer_id);

        $customer->update([
            'auth_code' => base64_encode($code),
        ]);

        // Envoie du code par sms
        $customer->user->notify(new ReinitCodeCustomer($code));

        return response()->json();
    }

    public function reinitAuth(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        $customer->user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        // Notification client
        $customer->user->notify(new ReinitAuthCustomer($customer));

        return response()->json();
    }

    public function verifUser($customer_id)
    {
        $customer = Customer::find($customer_id);

        try {
            $customer->info->update([
                'isVerified' => 1,
            ]);

            $this->PhoneVerification($customer);

            LogHelper::notify('notice', 'Client Vérifier');

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());

            return response()->json($exception->getMessage());
        }
    }

    public function verifSecure(Request $request, $code)
    {
        //dd($request->all(), $code);
        $customer = Customer::find($request->get('customer_id'));
        $code_customer = base64_decode($customer->auth_code);

        if ($code == $code_customer) {
            return response()->json();
        } else {
            return response()->json(['errors' => ['Le code SECURPASS est invalide']], 401);
        }
    }

    public function listeSepas($customer)
    {
        $customer = Customer::find($customer);
        $arr = [];

        foreach ($customer->wallets as $wallet) {
            foreach ($wallet->sepas as $sepa) {
                $arr[] = [
                    'id' => $sepa->id,
                    'account' => CustomerWalletHelper::getNameAccount($wallet),
                    'categorie' => 'Europrélèvement',
                    'creditor' => $sepa->creditor,
                    'mandat' => $sepa->number_mandate,
                    'montant' => eur($sepa->amount),
                    'status' => CustomerSepaHelper::getStatus($sepa->status, true),
                ];
            }
        }

        return response()->json($arr);
    }

    public function getMobility($mobility_id)
    {
        $mobility = CustomerMobility::with('bank', 'customer', 'wallet')->find($mobility_id);
        $other = [
            "status" => CustomerMobilityHelper::getStatus($mobility->status, 'label'),
            "start" => $mobility->start->format('d/m/Y'),
            "end_prov" => $mobility->end_prov->format("d/m/Y"),
            "env_real" => $mobility->env_real ? $mobility->env_real->format("d/m/Y") : "Non Définie",
            "end_prlv" => $mobility->end_prlv ? $mobility->end_prlv->format('d/m/Y') : "Non Définie",
        ];
        return response()->json(["mobility" => $mobility, "other" => $other]);
    }

    public function storeMobility(Request $request)
    {

    }

    private function PhoneVerification($customer)
    {
        try {
            $customer->info->notify(new PhoneVerificationNotification('sms', true));

            return null;
        } catch (\Exception $exception) {
            LogHelper::notify('error', $exception);

            return response()->json($exception->getMessage());
        }
    }
}
