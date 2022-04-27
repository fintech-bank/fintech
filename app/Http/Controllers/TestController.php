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
        $document = new DocumentFile();
        $customer = Customer::find(85);
        //dd($customer);
        return $document->generatePDF('agence.convention_part', $customer, 1, ["wallet" => $customer->wallets()->first(), "card" => $customer->wallets()->first()->cards()->first()], false, false, null, true, '');
        return view('pdf.agence.convention_part', [
            'data' => [],
            'agence' => $customer->user->agency,
            'document' => null,
            'title' => "Document",
            "header_type" => "address"
        ]);
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
