<?php

namespace App\Http\Controllers;

use App\Helper\AgencyHelper;
use App\Helper\CountryHelper;
use App\Helper\GeoHelper;
use Auth;
use Illuminate\Http\Request;
use Vicopo\Vicopo;

class TestController extends Controller
{
    public function test()
    {
        dd(GeoHelper::getCitiesFromCountry('france'));
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
