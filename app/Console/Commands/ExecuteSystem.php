<?php

namespace App\Console\Commands;

use App\Helper\CustomerHelper;
use App\Helper\CustomerTransactionHelper;
use App\Mail\Agent\ExecuteSystemMail;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExecuteSystem extends Command
{
    private $agents;
    private $date;

    public function __construct()
    {
        parent::__construct();
        $this->agents = User::where('agent', 1)->get();
        $this->date = now()->format('d/m/Y');
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:execute {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute commande';

    /**
     * Execute the console command.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|void
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'autoAcceptCreditPrlv':
                return $this->autoAcceptCreditPrlv();
                break;

            case 'verifRequestLoanOpen':
                return $this->verifRequestLoanOpen();
                break;

            case 'acceptedLoanCharge':
                return $this->acceptedLoanCharge();
                break;

            case 'executeSepaOrderDay':
                return $this->executeSepaOrderDay();
                break;

            case 'initPrlvCptEpargne':
                return $this->initPrlvCptEpargne();
                break;

            case 'initPrlvCptPret':
                return $this->initPrlvCptPret();
                break;

            case 'executeTransactionComing':
                return $this->executeTransactionComing();
                break;
        }
    }

    private function autoAcceptCreditPrlv()
    {
        $sepas = CustomerSepa::query()->where('status', 'waiting')->where('amount', '>=', 0)->get();

        $i = 0;

        foreach ($sepas as $sepa) {
            CustomerTransactionHelper::create(
                'credit',
                'sepa',
                "Prélèvement " . $sepa->creditor,
                $sepa->amount,
                $sepa->customer_wallet_id,
                true,
                null,
                now()
            );

            $i++;
        }

        $this->info('Acceptation automatique des prélèvement SEPA en crédit');
        $this->line('Nombre de prélèvement: '.$i);

    }

    private function verifRequestLoanOpen()
    {
        $loans = CustomerPret::where('status', 'open')->get();
        $i = 0;

        foreach ($loans as $loan) {
            $loan->update([
                'status' => 'study'
            ]);
            $i++;
        }

        $this->info('Passage des pret bancaire ouvert à en étude');
        $this->line('Nombre de pret bancaire: '.$i);
    }

    private function acceptedLoanCharge()
    {
        $loans = CustomerPret::where('status', 'accepted')->get();
        $i = 0;

        foreach ($loans as $loan) {
            if ($loan->updated_at > now()->addDays(8)) {
                $loan->wallet->update([
                    'balance_coming' => $loan->wallet->balance_coming - $loan->amount_loan,
                    'balance_actual' => $loan->wallet->balance_actual + $loan->amount_loan
                ]);
                $i++;
            }
        }

        $this->info('Virement du montant des pret bancaire en date du '.$this->date);
        $this->line('Nombre de virement executer: '.$i);
    }

    private function initPrlvCptEpargne()
    {
        $epargnes = CustomerEpargne::all();
        $i = 0;

        foreach ($epargnes as $epargne) {
            $now = now()->subDays(5)->startOfDay();
            $prlv_day = Carbon::create(now()->year, now()->month, $epargne->monthly_days)->startOfDay();

            $wallet_retrait = CustomerWallet::find($epargne->wallet_payment_id);
            if ($prlv_day == $now) {
                CustomerSepa::query()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => CustomerHelper::getName($epargne->wallet->customer),
                    'number_mandate' => \Str::upper(\Str::random(8)),
                    'amount' => -$epargne->monthly_payment,
                    'status' => 'waiting',
                    'created_at' => now(),
                    'updated_at' => $prlv_day,
                    'customer_wallet_id' => $wallet_retrait->id
                ]);

                CustomerSepa::query()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => CustomerHelper::getName($epargne->wallet->customer),
                    'number_mandate' => \Str::upper(\Str::random(8)),
                    'amount' => -$epargne->monthly_payment,
                    'status' => 'waiting',
                    'created_at' => now(),
                    'updated_at' => $prlv_day,
                    'customer_wallet_id' => $epargne->wallet->id
                ]);
                $i++;
            }
        }

        $this->info('Création des prélèvements des comptes épargnes en date du '.$this->date);
        $this->line("Nombre d'initialisation': ".$i);
    }

    private function initPrlvCptPret()
    {
        $loans = CustomerPret::all();
        $i = 0;

        foreach ($loans as $loan) {
            $now = now()->subDays(5)->startOfDay();
            $prlv_day = Carbon::create(now()->year, now()->month, $loan->prlv_day)->startOfDay();

            $wallet_retrait = CustomerWallet::find($loan->wallet_payment_id);

            if($prlv_day == $now) {
                CustomerSepa::query()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => config('app.name'),
                    'number_mandate' => \Str::upper(\Str::random(8)),
                    'amount' => - $loan->mensuality,
                    'status' => 'waiting',
                    'created_at' => now(),
                    'updated_at' => $prlv_day,
                    'customer_wallet_id' => $wallet_retrait->id
                ]);

                CustomerSepa::query()->create([
                    'uuid' => \Str::uuid(),
                    'creditor' => config('app.name'),
                    'number_mandate' => \Str::upper(\Str::random(8)),
                    'amount' => - $loan->mensuality,
                    'status' => 'waiting',
                    'created_at' => now(),
                    'updated_at' => $prlv_day,
                    'customer_wallet_id' => $loan->wallet->id
                ]);
                $i++;
            }
        }

        \Mail::to($this->agents)->send(new \App\Mail\Agent\ExecuteSystem("Création des prélèvements des mensualité de pret en date du " . $this->date . ".<br>Nombre d'initialisation: " . $i));
        $this->info('Création des prélèvements des mensualité de pret en date du '.$this->date);
        $this->line("Nombre d'initialisation': ".$i);
    }

    private function executeSepaOrderDay()
    {
        $sepas = CustomerSepa::all();
        $i = 0;

        foreach ($sepas as $sepa) {
            if ($sepa->updated_at->startOfDay() == now()->startOfDay()) {
                if ($sepa->amount <= 0) {
                    CustomerTransactionHelper::create('debit', 'sepa', 'Prélèvement SEPA - ' . $sepa->creditor, $sepa->amount, $sepa->customer_wallet_id);
                } else {
                    CustomerTransactionHelper::create('credit', 'sepa', 'Prélèvement SEPA - ' . $sepa->creditor, $sepa->amount, $sepa->customer_wallet_id);
                }
                $i++;
            }
        }

        \Mail::to($this->agents)->send(new \App\Mail\Agent\ExecuteSystem("Execution des ordres SEPA en date du " . now()->format('d/m/Y') . "<br>Nombre d'ordre executer: " . $i));
        $this->info('Execution des ordres SEPA en date du '.$this->date);
        $this->line("Nombre d'ordre executer': ".$i);
    }

    private function executeTransactionComing()
    {
        $transactions = CustomerTransaction::where('confirmed', false)->get();
        $v = 0;

        try {
            foreach ($transactions as $transaction) {
                if($transaction->updated_at <= now()->between(now()->startOfDay(), now()->endOfDay())) {
                    CustomerTransactionHelper::updated($transaction);
                    $v++;
                }
            }
            $this->line("Nombre de transaction passée: ".$v);
        }catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }


}
