<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerCreditCard;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerCreditCardController extends Controller
{
    public function store(Request $request, $customer)
    {
        $customer = Customer::find($customer);

        //Validation
        $request->validate([
            'customer_wallet_id' => "required",
            'type' => 'required',
        ]);

        //Création de la carte bancaire
        try {
            $card = CustomerCreditCard::createCard(
                $customer,
                $customer->wallets()->find($request->get('customer_wallet_id')),
                $request->get('type'),
                $request->get('support'),
                $request->get('debit')
            );

            return response()->json($card);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
