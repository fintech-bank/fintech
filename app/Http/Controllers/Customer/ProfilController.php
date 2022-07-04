<?php

namespace App\Http\Controllers\Customer;

use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Services\Stripe;
use App\Services\Twillo;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Laravel\Fortify\Rules\Password;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Lookups;

class ProfilController extends Controller
{
    public function index(Stripe $stripe)
    {
        return view('customer.profil.index', [
            'customer' => Customer::where('user_id', auth()->user()->id)->first(),
            'client_secret' => $stripe->client->identity->verificationSessions->create([
                'type' => 'document',
                'metadata' => [
                    'customer_id' => Customer::where('user_id', auth()->user()->id)->first()->id,
                    'previous_url' => url()->previous(true)
                ]
            ])->client_secret,
        ]);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        switch ($request->get('action')) {
            case 'updateSecurePhone':
                if ($this->phoneVerificationToken($request->get('mobile')) == true) {
                    Customer::find($request->user()->customer)->info->update([
                        'mobile' => $request->get('mobile')
                    ]);

                    return response()->json(['mobile' => $request->get('mobile')]);
                } else {
                    LogHelper::notify('critical', 'Le numéro de téléphone n\'exist pas');
                    return response()->json(null, 500);
                }
                break;

            case 'updatePreference':
                try {
                    $request->user()->customers->setting->update([
                        'notif_sms' => $request->has('notif_sms') ? 1 : 0,
                        'notif_app' => $request->has('notif_app') ? 1 : 0,
                        'notif_mail' => $request->has('notif_mail') ? 1 : 0,
                    ]);

                    return response()->json();
                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json($exception, 500);
                }
                break;

            case 'updateInfoPerso':
                if($request->get('email') != UserHelper::emailObscurate($request->user()->email)) {
                    $request->validate(['email' => "email"]);
                    $this->updateUser($request->user()->customers, $request);
                }

                try {
                    $this->updateInfo($request->user()->customers, $request);

                    return response()->json();
                }catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(['errors' => $exception], 500);
                }
                break;

            case 'updatePassword':
                $request->validate([
                    'new_password' => new Password
                ]);

                try {
                    $request->user()->update([
                        'password' => \Hash::make($request->get('new_password'))
                    ]);

                    return response()->json();
                }catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(['errors' => $exception], 500);
                }
                break;

            case 'updateSecurpass':
                $request->validate([
                    'auth_code' => 'numeric'
                ]);

                try {
                    $request->user()->customers->update([
                        'auth_code' => base64_encode($request->get('auth_code'))
                    ]);

                    return response()->json();
                }catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(['errors' => $exception], 500);
                }
                break;

            default:
                return response()->json(null, 404);
        }
    }

    public function requestPassword()
    {
        return view('customer.profil.password', [
            'customer' => auth()->user()->customers,
            'agent' => new Agent()
        ]);
    }

    private function phoneVerificationToken($mobile)
    {
        $twilio = new Twillo();
        $look = new Lookups($twilio->client);

        try {
            if ($look->phoneNumbers($mobile)->fetch()) {
                return true;
            } else {
                return false;
            }
        } catch (TwilioException $exception) {
            return ['error' => $exception];
        }
    }

    private function updateUser($customer, $request)
    {
        try {
            $customer->user->update([
                'email' => $request->get('email')
            ]);

            return null;
        }catch (\Exception $exception) {
            return $exception;
        }
    }

    private function updateInfo($customer, $request)
    {
        try {
            $customer->info->update($request->except(['_token', 'action', 'email']));
            return null;
        }catch (\Exception $exception) {
            return $exception;
        }
    }

}
