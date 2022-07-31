<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Carbon\Carbon;

class StatController extends Controller
{
    public function stat()
    {
        return response()->json([
            'deposit' => $this->sumAllDepositChart(),
            'withdraw' => $this->sumAllWithdrawChart(),
            'sumAllDeposit' => eur(CustomerTransaction::query()->where('type', 'depot')->sum('amount')),
            'sumAllDepositCharge' => eur(CustomerTransaction::query()->where('type', 'depot')->where('confirmed', false)->sum('amount')),
            'sumAllWithdraw' => eur(-CustomerTransaction::query()->where('type', 'retrait')->sum('amount')),
            'sumAllWithdrawCharge' => eur(-CustomerTransaction::query()->where('type', 'retrait')->where('confirmed', false)->sum('amount')),
            'sumAllTransactionBalance' => eur(CustomerTransaction::query()->sum('amount')),
            'dispoPret' => eur(CustomerTransaction::query()->sum('amount') / 3),
        ]);
    }

    private function sumAllDepositChart()
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = CustomerTransaction::query()->where('type', 'depot')->whereBetween('created_at', [Carbon::create(now()->year, $i, 1)->startOfMonth(), Carbon::create(now()->year, $i, 1)->endOfMonth()])->sum('amount');
        }

        return $data;
    }

    private function sumAllWithdrawChart()
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = -CustomerTransaction::query()->where('type', 'retrait')->whereBetween('created_at', [Carbon::create(now()->year, $i, 1)->startOfMonth(), Carbon::create(now()->year, $i, 1)->endOfMonth()])->sum('amount');
        }

        return $data;
    }
}
