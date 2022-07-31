<?php

namespace App\Console\Commands;

use App\Helper\CustomerWalletHelper;
use App\Models\Customer\CustomerWallet;
use Illuminate\Console\Command;

class VerifSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:verif {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute les vérifications sur le système bancaire';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'alertDebit':
                $count = $this->verifAlertDebit();
                $this->info('Nombre de compte: '.$count);
                break;

            case 'accountReopen':
                $count = $this->verifAccountReopen();
                $this->info('Nombre de compte: '.$count);
                break;

            case 'alertFee':
                $count = $this->verifAlertFee();
                $this->info('Nombre de compte: '.$count);
                break;

            case 'accountSuspended':
                $count = $this->verifSuspendedAccount();
                $this->info('Nombre de compte: '.$count);
                break;

            default:
                $count = $this->verifAccountReopen();
                $this->info('Nombre de compte: '.$count);
        }
    }

    private function verifAccountReopen()
    {
        $wallets = CustomerWallet::query()
            ->where('type', 'compte')
            ->where('status', 'active')
            ->orWhere('type', 'epargne')
            ->get();

        $count = 0;

        foreach ($wallets as $wallet) {
            if ($wallet->alert_debit == 1 && CustomerWalletHelper::getSoldeRemaining($wallet) >= 0) {
                $wallet->update([
                    'alert_debit' => 0,
                    'alert_fee' => 0,
                    'alert_date' => null,
                    'status' => 'active',
                ]);
                $count++;
            }
        }

        return $count;
    }

    private function verifAlertDebit()
    {
        $wallets = CustomerWallet::query()
            ->where('type', 'compte')
            ->where('status', 'active')
            ->orWhere('type', 'epargne')
            ->get();

        $count = 0;

        foreach ($wallets as $wallet) {
            if ($wallet->alert_debit == 0 && CustomerWalletHelper::getSoldeRemaining($wallet) <= 0) {
                $wallet->update([
                    'alert_debit' => 1,
                    'alert_date' => now(),
                ]);
                $count++;
            }
        }

        return $count;
    }

    private function verifAlertFee()
    {
        $wallets = CustomerWallet::query()
            ->where('type', 'compte')
            ->where('status', 'active')
            ->orWhere('type', 'epargne')
            ->get();

        $count = 0;

        foreach ($wallets as $wallet) {
            if ($wallet->alert_debit == 1 && $wallet->alert_date->startOfDay() >= now()->addDays(15)->startOfDay()) {
                $wallet->update([
                    'alert_fee' => 1,
                ]);
                $count++;
            }
        }

        return $count;
    }

    private function verifSuspendedAccount()
    {
        $wallets = CustomerWallet::query()
            ->where('type', 'compte')
            ->where('status', 'active')
            ->orWhere('type', 'epargne')
            ->get();

        $count = 0;

        foreach ($wallets as $wallet) {
            if ($wallet->alert_debit == 1 && $wallet->alert_fee == 1 && $wallet->alert_date->startOfDay() >= now()->addDays(15)->startOfDay()) {
                $wallet->update([
                    'status' => 'suspended',
                ]);
                $count++;
            }
        }

        return $count;
    }
}
