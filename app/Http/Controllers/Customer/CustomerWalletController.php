<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Services\Stripe;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function index(Request $request, $wallet_id)
    {
        if($request->get('action') == 'refund_success') {
            $wallet = CustomerWallet::find($wallet_id);
            $customer = $wallet->customer;

            return view('customer.wallet.index', [
                'wallet' => $wallet,
                'customer' => $customer,
                'refund_success'
            ]);
        } else {
            $wallet = CustomerWallet::find($wallet_id);
            $customer = $wallet->customer;

            return view('customer.wallet.index', compact('wallet', 'customer'));
        }
    }

    public function refund(Request $request, $wallet, Stripe $stripe)
    {
        $wallet = CustomerWallet::find($wallet);
        try {
            $session = $stripe->client->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => route('customer.wallet.refundSuccess', $wallet->id),
                'cancel_url' => route('customer.wallet.refundCancel', $wallet->id),
                'shipping_address_collection' => [
                    'allowed_countries' => ['FR']
                ],
                'line_items' => [
                    [
                        'quantity' => 1,
                        'price_data' => [
                            'currency' => 'EUR',
                            'product_data' => [
                                'name' => "Approvisionnement du compte N°".$wallet->number_account
                            ],
                            'unit_amount' => $request->get('amount')*100
                        ]
                    ]
                ],
                'metadata' => [
                    'amount' => $request->get('amount')
                ]
            ]);

            $wallet->refunds()->create([
                'stripe_id' => $session->id,
                'customer_wallet_id' => $wallet->id
            ]);

            return response()->json(['url' => $session->url]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception, 500);
        }
    }

    public function refundSuccess($wallet_id, Stripe $stripe)
    {
        $wallet = CustomerWallet::find($wallet_id);
        $refund = $wallet->refunds()->first();

        $session = $stripe->client->checkout->sessions->retrieve($refund->stripe_id);

        if($session->status == 'complete') {
            CustomerTransactionHelper::create('credit', 'depot', 'Approvisionnement du compte', $session->amount_total/100, $wallet->id, true, 'Approvisionnement du compte par stripe', now());
        } else {
            CustomerTransactionHelper::create('credit', 'depot', 'Approvisionnement du compte', $session->amount_total/100, $wallet->id, false, 'Approvisionnement du compte par stripe', null, now());
        }

        $refund->delete();

        return redirect()->route('customer.wallet.index', [$wallet_id, 'action' => "refund_success"]);
    }
}
