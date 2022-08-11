<?php

namespace App\Http\Controllers;

use App\Helper\DocumentFile;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerWallet;
use App\Services\BankFintech;
use App\Services\Ovh;
use Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $doc = new DocumentFile();
        $customer = Customer::find(122);
        $card = CustomerCreditCard::find(20);
        $wallet = CustomerWallet::find(127);

        return $doc->generatePDF('agence.condition_general_banque_distance', $customer, null, ["card" => $card, "wallet" => $wallet], false, false, null, true);
    }

    public function home()
    {
        return redirect()->route('login');
    }

    public function pushStore(Request $request)
    {
        $this->middleware('auth');

        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
}
