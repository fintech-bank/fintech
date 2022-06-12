<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Mail\Agent\ExecuteSystemMail;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use Illuminate\Console\Command;

class ExecuteSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:execute {call}';

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
        switch ($this->argument('call')) {
            case 'autoAcceptCreditPrlv':
                return $this->autoAcceptCreditPrlv();
                break;

            case 'verifRequestLoanOpen':
                return $this->verifRequestLoanOpen();
                break;

            case 'acceptedLoanCharge':
                return $this->acceptedLoanCharge();
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
                "Prélèvement ".$sepas->creditor,
                $sepa->amount,
                $sepa->customer_wallet_id,
                true,
                null,
                now()
            );

            $i++;
        }

        \Mail::to(auth()->user())->send(new ExecuteSystemMail('autoAcceptCreditPrlv', $i));

        return $sepas;
    }

    private function verifRequestLoanOpen() {
        $loans = CustomerPret::where('status', 'open')->get();

        foreach ($loans as $loan) {
            $loan->update([
                'status' => 'study'
            ]);
        }
    }

    private function acceptedLoanCharge()
    {
        $loans = CustomerPret::where('status', 'accepted')->get();

        foreach ($loans as $loan) {
            if($loan->updated_at > now()->addDays(8)) {
                $loan->wallet->update([
                    'balance_coming' => $loan->wallet->balance_coming - $loan->amount_loan,
                    'balance_actual' => $loan->wallet->balance_actual + $loan->amount_loan
                ]);
            }
        }
    }


}
