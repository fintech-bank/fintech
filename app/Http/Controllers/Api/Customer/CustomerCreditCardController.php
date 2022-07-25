<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCreditCard;
use App\Notifications\Agent\RequestOppositCardNotification;
use Illuminate\Http\Request;

class CustomerCreditCardController extends Controller
{
    public function activate($card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => "active"
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }

    public function desactivate($card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => "inactive"
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }

    public function opposit(Request $request, $card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => "inactive"
            ]);

            $card->wallet->customer->agent->notify(new RequestOppositCardNotification($card->wallet->customer, $card, $request->get('type_opposit')));

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }
}
