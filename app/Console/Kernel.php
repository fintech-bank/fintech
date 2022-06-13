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
        $schedule->command('system:execute call=autoAcceptCreditPrlv')
            ->hourly()
            ->description("Accepte automatiquement les prélèvement Créditeur toute les heures");

        $schedule->command('system:execute call=verifRequestLoanOpen')
            ->dailyAt('08:00:00')
            ->description("Passe tous les pret ouvert en étude");

        $schedule->command('system:execute call=acceptedLoanCharge')
            ->dailyAt('08:00:00')
            ->description("Effectue le virement du montant des pret accordées");

        $schedule->command('system:execute call=initPrlvCptEpargne')
            ->dailyAt('08:00:00')
            ->description("Initialise tous les prélèvements à effectuer sur les comptes épargne");

        $schedule->command('system:execute call=initPrlvCptPret')
            ->dailyAt('08:00:00')
            ->description("Initialise tous les prélèvements à effectuer sur les comptes de pret");

        $schedule->command('system:execute call=executeSepaOrderDay')
            ->daily()
            ->description("Exécute tous les ordres de prélèvement sépa journalier");
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
