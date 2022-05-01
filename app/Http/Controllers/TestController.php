<?php

namespace App\Http\Controllers;

use App\Helper\CustomerCreditCard;
use App\Helper\DocumentFile;
use App\Models\Customer\Customer;
use Auth;
use IbanGenerator\Generator;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function test()
    {
        $customer = Customer::find(29);
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->with('transactions')->get() as $wallet) {
            dd($wallet->transactions()->where('type', 'virement')->orWhere('type', 'sepa')->get());
            $ds = $wallet->transactions()->where('type', 'virement')->where('type', 'sepa')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);

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
