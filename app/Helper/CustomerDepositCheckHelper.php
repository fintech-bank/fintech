<?php

namespace App\Helper;

use App\Models\Customer\Customer;

class CustomerDepositCheckHelper
{
    public static int $limit_deposit_month_part = 10000;
    public static int $limit_deposit_month_pro = 100000;

    public static function getAmountMonthDeposit(Customer $customer): mixed
    {
        $amount = 0;

        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $amount += $wallet->deposits()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->where('state', 'terminated')->sum('amount');
        }

        return $amount;
    }

    public static function calcCountPendingDeposit(Customer $customer)
    {
        $count = 0;
        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $count += $wallet->deposits()->where('state', 'pending')->count();
        }

        return $count;
    }
}
