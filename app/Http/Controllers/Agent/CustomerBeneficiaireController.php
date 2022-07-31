<?php

namespace App\Http\Controllers\Agent;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\Customer\CreateBeneficiaireNotification;
use Illuminate\Http\Request;
use Intervention\Validation\Rules\Bic;
use Intervention\Validation\Rules\Iban;

class CustomerBeneficiaireController extends Controller
{
    public function store(Request $request, $customer, $wallet)
    {
        $customer = Customer::query()->find($customer);
        $wallet = CustomerWallet::query()->find($wallet);
        $request->validate([
            'type' => 'required',
            'bank_id' => 'required',
            'bic' => new Bic(),
            'iban' => new Iban(),
        ]);

        try {
            $beneficiaire = CustomerBeneficiaire::query()->create([
                'uuid' => \Str::uuid(),
                'type' => $request->get('type'),
                'company' => $request->get('type') == 'corporate' ? $request->get('company') : null,
                'civility' => $request->get('type') == 'retail' ? $request->get('civility') : null,
                'firstname' => $request->get('type') == 'retail' ? $request->get('firstname') : null,
                'lastname' => $request->get('type') == 'retail' ? $request->get('lastname') : null,
                'bank_id' => $request->get('bank_id'),
                'bankname' => $request->get('bankname'),
                'bic' => $request->get('bic'),
                'iban' => $request->get('iban'),
                'titulaire' => $request->has('titulaire'),
                'customer_id' => $customer->id,
            ]);

            auth()->user()->notify(new CreateBeneficiaireNotification($customer, $beneficiaire, $wallet));

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage(), 500);
        }
    }

    public function update(Request $request, $customer, $wallet, $beneficiaire)
    {
        $beneficiaire = CustomerBeneficiaire::query()->find($beneficiaire);

        try {
            $beneficiaire->update([
                'type' => $request->get('type'),
                'company' => $request->get('type') == 'corporate' ? $request->get('company') : null,
                'civility' => $request->get('type') == 'retail' ? $request->get('civility') : null,
                'firstname' => $request->get('type') == 'retail' ? $request->get('firstname') : null,
                'lastname' => $request->get('type') == 'retail' ? $request->get('lastname') : null,
                'bankname' => $request->get('bankname'),
                'bic' => $request->get('bic'),
                'iban' => $request->get('iban'),
                'titulaire' => $request->has('titulaire'),
                'customer_id' => $customer->id,
            ]);
        } catch (\Exception $exception) {
        }
    }

    public function delete($customer, $wallet, $beneficiaire)
    {
        try {
            $beneficiaire = CustomerBeneficiaire::query()->find($beneficiaire);

            if ($beneficiaire->transfers()->count() == 0) {
                $beneficiaire->delete();

                return response()->json(['state' => 'success']);
            } else {
                return response()->json(['state' => 'transfer_execute']);
            }
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return response()->json($exception->getMessage(), 500);
        }
    }
}
