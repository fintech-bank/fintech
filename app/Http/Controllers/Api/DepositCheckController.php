<?php

namespace App\Http\Controllers\Api;

use App\Helper\DatatableHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCheckDeposit;
use App\Notifications\Customer\CreateValidDepositCheckNotification;
use Illuminate\Http\Request;

class DepositCheckController extends Controller
{
    public function listChecks(Request $request, $deposit_id)
    {
        $deposit = CustomerCheckDeposit::find($deposit_id);

        return response()->json([
            "deposit" => $deposit,
            "lists" => $deposit->lists
        ]);
    }

    public function validDeposit($deposit_id)
    {
        $deposit = CustomerCheckDeposit::find($deposit_id);

        try {
            if ($deposit->lists()->count() == $deposit->lists()->where('verified', 1)->count()) {
                $deposit->update([
                    'state' => 'terminated'
                ]);

                $deposit->transaction()->update([
                    'confirmed' => true,
                    'confirmed_at' => now()
                ]);

                $deposit->wallet->customer->user->notify(new CreateValidDepositCheckNotification($deposit->wallet->customer, $deposit));
            } else {
                $deposit->update([
                    'state' => 'progress'
                ]);
            }

            return response()->json($deposit);
        }catch (\Exception $exception) {
            api_error('XS-000', $exception->getMessage());
            return response()->json([
                'errors' => [
                    $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function declineDeposit($deposit_id)
    {
        $deposit = CustomerCheckDeposit::find($deposit_id);

        try {
            $deposit->delete();

            return response()->json($deposit);
        }catch (\Exception $exception) {
            api_error('XS-000', $exception->getMessage());
            return response()->json([
                'errors' => [
                    $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function acceptCheck($deposit_id, $check_id)
    {
        $deposit = CustomerCheckDeposit::find($deposit_id);
        $check = $deposit->lists()->find($check_id);

        try {
            $check->isVerified();

            return response()->json();
        } catch (\Exception $exception) {
            api_error('XS-000', $exception->getMessage());
            return response()->json([
                'errors' => [
                    $exception->getMessage()
                ]
            ], 500);
        }
    }

    public function declineCheck($deposit_id, $check_id)
    {
        $deposit = CustomerCheckDeposit::find($deposit_id);
        $check = $deposit->lists()->find($check_id);

        try {
            $check->isUnverified();

            return response()->json();
        } catch (\Exception $exception) {
            api_error('XS-000', $exception->getMessage());
            return response()->json([
                'errors' => [
                    $exception->getMessage()
                ]
            ], 500);
        }
    }
}
