<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerCreditCard;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Notifications\Customer\SendCodeCardNotification;
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

    public function show($customer, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        return view('agent.customer.card.show', [
            'card' => $card,
            'customer' => Customer::find($customer)
        ]);
    }

    public function update(Request $request, $customer, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        try {
            $card->update([
                'debit' => $request->get('debit'),
                'differed_limit' => $request->get('debit') == 'differed' ? $request->get('differed_limit') : 0,
                'payment_internet' => $request->has('payment_internet') ? 1 : 0,
                'payment_abroad' => $request->has('payment_abroad') ? 1 : 0,
                'payment_contact' => $request->has('payment_contact') ? 1 : 0,
            ]);

            DocumentFile::createDoc(
                $card->wallet->customer,
                'Convention CB Physique',
                'Avenant Contrat CB VISA Physique',
                3,
                null,
                true,
                true,
                false,
                true,
                ['card' => $card]);

            return response()->json($card);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    public function active($customer, $card)
    {
       $card = \App\Models\Customer\CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'active'
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(['errors' => $exception->getMessage()]);
        }
    }

    public function inactive($customer, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'inactive'
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(['errors' => $exception->getMessage()]);
        }
    }

    public function canceled($customer, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'canceled'
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(['errors' => $exception->getMessage()]);
        }
    }

    public function code($customer, $card)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card);

        try {
            $new_code = base64_encode(rand(1000,9999));

            $card->update([
                'code' => $new_code
            ]);

            $card->wallet->customer->info->notify(new SendCodeCardNotification($card->wallet->customer, $new_code, $card));

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json(['errors' => $exception->getMessage()]);
        }
    }
}
