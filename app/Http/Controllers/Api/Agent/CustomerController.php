<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Mail\Agent\Customer\WriteMail;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInfo;
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

    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if ($wallet->balance_actual < 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "outdated"
                ];
            } else {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "ok"
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
            LogHelper::notify('notice', "Mise à jour du status du compte client: " . CustomerHelper::getName($customer));
            return response()->json([
                "status" => CustomerHelper::getStatusOpenAccount($request->get('status_open_account'))
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
                "body" => $request->get('message'),
                "from" => config('twilio-notification-channel.from')
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
                'password' => \Hash::make($password)
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
            'auth_code' => base64_encode($code)
        ]);

        // Envoie du code par sms
        $customer->info->notify(new ReinitCodeCustomer($code));
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
                'isVerified' => 1
            ]);

            $this->PhoneVerification($customer);

            LogHelper::notify('notice', "Client Vérifier");
            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    private function PhoneVerification($customer)
    {
        try {
            $customer->info->notify(new PhoneVerificationNotification('sms', true));

            return null;
        }catch (\Exception $exception) {
            LogHelper::notify('error', $exception);
            return response()->json($exception->getMessage());
        }
    }
}
