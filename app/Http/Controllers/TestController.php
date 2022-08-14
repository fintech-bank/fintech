<?php

namespace App\Http\Controllers;

use App\Models\Core\Bank;
use App\Models\Customer\Customer;
use App\Services\BankFintech;
use Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $fin = new BankFintech();
        $customer = Customer::find(1);
        $agence = $customer->agency;

        dd($fin->callTransferDoc($customer, $agence, "MDB-GTFTDTKDKLLF-202208141705-00001"));
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
