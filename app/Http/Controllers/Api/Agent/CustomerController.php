<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Notifications\Agent\Customer\UpdateStatusAccountNotification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if($wallet->balance_actual <= 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "outdated"
                ];
            } else {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "ok"
                ];
            }
        }

        return $wallets;
    }

    public function updateStatus(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);
        try {
            $customer->status_open_account = $request->get('status_open_account');
            $customer->save();

            // Notification Agent
            $request->user()->notify(new UpdateStatusAccountNotification($customer, $request->get('status_open_account')));

            // Notification Client
            $customer->user->notify(new \App\Notifications\Customer\UpdateStatusAccountNotification($customer, $request->get('status_open_account')));

            // response
            LogHelper::notify('notice', "Mise à jour du status du compte client: ".CustomerHelper::getName($customer));
            return response()->json([
                "status" => CustomerHelper::getStatusOpenAccount($request->get('status_open_account'))
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());
            return response()->json();
        }
    }
}
