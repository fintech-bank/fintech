<?php

namespace App\Http\Controllers\Agent;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Http\Request;

class CustomerTransactionController extends Controller
{
    public function confirm($customer, $wallet, $transaction)
    {
        try {
            CustomerTransaction::find($transaction)->update([
                'confirmed' => true,
                'confirmed_at' => now()
            ]);

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
