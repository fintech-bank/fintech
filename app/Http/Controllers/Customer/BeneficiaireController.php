<?php

namespace App\Http\Controllers\Customer;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use App\Models\Customer\CustomerBeneficiaire;
use Illuminate\Http\Request;
use Intervention\Validation\Rules\Bic;
use Intervention\Validation\Rules\Iban;

class BeneficiaireController extends Controller
{
    public function index()
    {
        return view('customer.transfer.beneficiaire', [
            'customer' => auth()->user()->customers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'iban' => new Iban(),
            'bic' => new Bic(),
        ]);

        $bank = Bank::find($request->get('bank_id'));
        $request->merge([
            'uuid' => \Str::uuid(),
            'bankname' => $bank->name,
            'customer_id' => auth()->user()->customers->id,
        ]);

        try {
            $beneficiaire = CustomerBeneficiaire::query()->create($request->all());

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json($exception, 500);
        }
    }

    public function update(Request $request, $beneficiaire)
    {
        try {
            CustomerBeneficiaire::query()->find($beneficiaire)->update($request->except('_token'));

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json($exception, 500);
        }
    }

    public function delete($beneficiaire)
    {
        try {
            CustomerBeneficiaire::query()->find($beneficiaire)->delete();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json(['error' => $exception], 500);
        }
    }
}
