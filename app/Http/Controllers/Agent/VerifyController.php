<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Mail\Customer\VerifyIdentity;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Stripe\Stripe;

class VerifyController extends Controller
{
    public function go(\App\Services\Stripe $stripe, $customer_id)
    {
        $customer = Customer::find($customer_id);
        $session = $stripe->client->identity->verificationSessions->create([
            'type' => 'document',
            'metadata' => [
                "customer_id" => $customer_id
            ]
        ]);

        \Mail::to($customer->user)->send(new VerifyIdentity($customer, $session->url));

        return response()->json([$customer, $session->url]);
    }
}
