<?php

namespace App\Http\Controllers\Api\Withdraw;

use App\Helper\CustomerWalletHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Models\Customer\CustomerWithdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function info(Request $request)
    {
        switch ($request->get('action')) {
            case 'requestCard':
                return response()->json($this->requestCard($request->get('id')));
        }
    }

    public function get($id)
    {
        $with = CustomerWithdraw::find($id);

        return response()->json($with);
    }

    public function delete($id)
    {
        try {
            $with = CustomerWithdraw::find($id);

            $with->transaction->delete();

            $with->delete();

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::error($exception->getMessage(), $exception);

            return response()->json([
                'errors' => [
                    $exception->getMessage()
                ]
            ], 500);
        }
    }

    private function requestCard($wallet)
    {
        return CustomerWallet::find($wallet)->cards()->where('status', 'active')->first()->load('wallet');
    }
}
