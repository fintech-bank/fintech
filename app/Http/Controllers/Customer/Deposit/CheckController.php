<?php

namespace App\Http\Controllers\Customer\Deposit;

use App\Helper\CustomerDepositCheckHelper;
use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCheckDeposit;
use App\Notifications\Customer\CreateDepositCheckNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckController extends Controller
{
    public function index()
    {
        $wallets = auth()->user()->customers->wallets()->with('deposits')->where('type', 'compte')->orWhere('type', 'epargne')->where('customer_id', auth()->user()->customers->id)->get();
        //dd($checks);

        return view('customer.deposit.check.index', [
            'customer' => \request()->user()->customers,
            'wallets' => $wallets,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $deposit = CustomerCheckDeposit::create([
                'reference' => Str::upper(Str::random(8)),
                'customer_wallet_id' => $request->get('customer_wallet_id')
            ]);
            try {
                foreach ($request->get('check_lists') as $check) {
                    $deposit->lists()->create([
                        'number' => $check['number'],
                        'amount' => $check['amount'],
                        'name_deposit' => $check['name_deposit'],
                        'bank_deposit' => $check['bank_deposit'],
                        'date_deposit' => Carbon::createFromTimestamp(strtotime($check['date_deposit'])),
                        'customer_check_deposit_id' => $deposit->id
                    ]);

                    $deposit->update([
                        'amount' => $deposit->amount + $check['amount']
                    ]);
                }

                $transaction = CustomerTransactionHelper::create('credit', 'depot', 'Remise de chèque N°'.$deposit->reference, $deposit->amount, $deposit->customer_wallet_id, false, 'Remise de chèque N°'.$deposit->reference, null, now());

                $deposit->update(['customer_transaction_id' => $transaction->id]);

                $deposit->wallet->customer->user->notify(new CreateDepositCheckNotification($deposit->wallet->customer, $deposit));

                return response()->json($deposit);
            }catch (\Exception $exception) {
                $err = api_error('X-001-500', $exception->getMessage());
                return response()->json($err, 500);
            }
        }catch (\Exception $exception) {
            $err = api_error('X-001-500', $exception->getMessage());
            return response()->json($err, 500);
        }
    }
}
