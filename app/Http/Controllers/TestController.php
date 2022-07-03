<?php

namespace App\Http\Controllers;

use App\Helper\CustomerCreditCard;
use App\Helper\DocumentFile;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Services\BankFintech;
use App\Services\Twillo;
use Auth;
use IbanGenerator\Generator;
use Illuminate\Http\Request;
use Twilio\Rest\Lookups;


class TestController extends Controller
{
    public function test()
    {
        $twilio = new Twillo();
        $look = new Lookups($twilio->client);

        dd($look->phoneNumbers('+33249063652')->fetch());
    }

    public function home()
    {
        return redirect()->route('login');
    }

    public function pushStore(Request $request)
    {
        $this->middleware('auth');

        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true],200);
    }
}
