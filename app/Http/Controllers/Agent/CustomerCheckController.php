<?php

namespace App\Http\Controllers\Agent;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\CheckCheckoutNotification;
use Illuminate\Http\Request;

class CustomerCheckController extends Controller
{
    public function store(Request $request, $customer, $wallet)
    {
        $customer = Customer::find($customer);
        $wallet = CustomerWallet::find($wallet);

        if($customer->fcc == true) {
            return response()->json(null, 426);
        } elseif($wallet->status != 'active'){
            return response()->json(null, 427);
        } else {
            try {
                $reference = rand(1000000,9999999);
                $check = CustomerCheck::query()->create([
                    'reference' => $reference,
                    'tranche_start' => $reference,
                    'tranche_end' => $reference + 40,
                    'customer_wallet_id' => $wallet->id
                ]);

                $customer->user->notify(new CheckCheckoutNotification($customer, $check));

                return response()->json($check);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage());
                return response()->json($exception->getMessage(), 500);
            }
        }
    }

    public function info($customer, $wallet, $check)
    {
        $check = CustomerCheck::query()->find($check);

        return response()->json($check);
    }

    public function destroy($customer, $wallet, $check)
    {
        try {
            CustomerCheck::find($check)->delete();

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }
}
