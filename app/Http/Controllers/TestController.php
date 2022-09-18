<?php

namespace App\Http\Controllers;

use App\Models\Core\Bank;
use App\Models\Customer\Customer;
use App\Services\BankFintech;
use App\Services\GooglePlaceApi;
use Auth;
use Illuminate\Http\Request;
use NSpehler\LaravelInsee\Facades\Insee;
use Vicopo\Vicopo;

class TestController extends Controller
{
    public function test()
    {
        $api = new GooglePlaceApi();
        //dd(geoip(\request()->ip()));
        $c = $api->call('distributeur');
        //$m = $c->where('opening_hours.open_now', true)->random();

        dd($c);
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
