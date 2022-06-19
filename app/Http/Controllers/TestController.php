<?php

namespace App\Http\Controllers;

use App\Helper\CustomerCreditCard;
use App\Helper\DocumentFile;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Services\BankFintech;
use Auth;
use IbanGenerator\Generator;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function test()
    {
        dd(json_decode(\App\Models\Core\LoanPlan::query()->select('name')->get()->toJson(), true));
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
