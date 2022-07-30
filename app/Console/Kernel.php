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
        $schedule->command('life generateCustomer')->hourly()->description('Génération aléatoire de client')->emailOutputTo(config('mail.from.address'));
        $schedule->command('life generateDebit')->everyTenMinutes()->description('Génération Aléatoire des débits');
        $schedule->command('life generateSalary')->monthlyOn(rand(1,5), '02:00:00')->description('Génération des salaires')->emailOutputTo(config('mail.from.address'));
        $schedule->command('life generatePrlvSepa')->dailyAt('07:00:00')->description('Génération des Prélèvements SEPA')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute autoAcceptCreditPrlv')->dailyAt('08:00:00')->description('Acceptation automatique des Prélèvement SEPA')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute acceptedLoanCharge')->dailyAt('08:00:00')->description('Libération du montant du pret bancaire')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute initPrlvCptEpargne')->dailyAt('08:00:00')->description('Initialise les prélèvements des comptes épargnes')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute initPrlvCptPret')->dailyAt('08:00:00')->description('Initialise les prélèvements des pret Bancaire')->emailOutputTo(config('mail.from.address'));
        $schedule->command('bank:execute virement')->everySixHours()->description('Vérification et execution des virements bancaires')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute executeSepaOrderDay')->everySixHours()->description('Execution des prélèvements bancaires')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute verifRequestLoanOpen')->everySixHours()->description('Vérification des pret ouvert et les met en étude')->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute executeTransactionComing')->everySixHours()->description('Execution des transactions entrente')->emailOutputTo(config('mail.from.address'));
        $schedule->command('life generateMensualReleve')->monthlyOn(1)->description("Génération des relevé mensuel")->emailOutputTo(config('mail.from.address'));
        $schedule->command('system:execute executeActiveAccount')->everySixHours()->description("Passage des compte accepté à terminer")->emailOutputTo(config('mail.from.address'));

        $schedule->command("system:verif alertDebit")->daily()->description("Vérification des comptes au solde négatif")->emailOutputTo(config('mail.from.address'));
        $schedule->command("system:verif accountReopen")->daily()->description("Vérification des comptes au solde de nouveau positif")->emailOutputTo(config('mail.from.address'));
        $schedule->command("system:verif alertFee")->daily()->description("Vérification des comptes au solde n&gatif depuis 15 jours")->emailOutputTo(config('mail.from.address'));
        $schedule->command("system:verif accountSuspended")->daily()->description("Vérification des comptes au solde n&gatif depuis 30 jours et suspend le comptes")->emailOutputTo(config('mail.from.address'));
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
