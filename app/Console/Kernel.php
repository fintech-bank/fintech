<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $startMonth = Carbon::create(now()->year, now()->month, 1);
        $endMonth = Carbon::create(now()->year, now()->month, 6);
        // $schedule->command('inspire')->hourly();
        $schedule->command('telescope:prune')->daily();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        // Commande
        $schedule->command('life generateCustomer')->hourly()->description('generateCustomer');
        $schedule->command('life generateDebit')->everyTenMinutes()->description('generateDebit');
        $schedule->command('life generateSalary')->monthlyOn(rand(1,5), '02:00:00')->description('generateSalary');
        $schedule->command('system:execute autoAcceptCreditPrlv')->dailyAt('08:00:00')->description('autoAcceptCreditPrlv');
        $schedule->command('system:execute acceptedLoanCharge')->dailyAt('08:00:00')->description('acceptedLoanCharge');
        $schedule->command('system:execute initPrlvCptEpargne')->dailyAt('08:00:00')->description('initPrlvCptEpargne');
        $schedule->command('system:execute initPrlvCptPret')->dailyAt('08:00:00')->description('initPrlvCptPret');
        $schedule->command('bank:execute virement')->everySixHours()->description('virement');
        $schedule->command('system:execute executeSepaOrderDay')->everySixHours()->description('executeSepaOrderDay');
        $schedule->command('system:execute verifRequestLoanOpen')->everySixHours()->description('verifRequestLoanOpen');
        $schedule->command('system:execute executeTransactionComing')->everySixHours()->description('executeTransactionComing');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
