<?php

namespace App\Console;

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
        // $schedule->command('inspire')->hourly();
        $schedule->command('telescope:prune')->daily();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        // Commande
        $schedule->command('life')->hourly();
        $schedule->command('system:execute call=autoAcceptCreditPrlv')->dailyAt('08:00:00');
        $schedule->command('system:execute call=acceptedLoanCharge')->dailyAt('08:00:00');
        $schedule->command('system:execute call=initPrlvCptEpargne')->dailyAt('08:00:00');
        $schedule->command('system:execute call=initPrlvCptPret')->dailyAt('08:00:00');
        $schedule->command('bank:execute call=virement')->dailyAt('08:00:00');
        $schedule->command('system:execute call=executeSepaOrderDay')->everySixHours();
        $schedule->command('system:execute call=verifRequestLoanOpen')->everySixHours();
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
