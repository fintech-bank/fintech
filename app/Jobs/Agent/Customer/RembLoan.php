<?php

namespace App\Jobs\Agent\Customer;

use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RembLoan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $loan;
    public $sepa;

    /**
     * Create a new job instance.
     *
     * @param $loan
     * @param $sepa
     */
    public function __construct($loan, $sepa)
    {
        //
        $this->loan = $loan;
        $this->sepa = $sepa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Vérifier le solde du compte de paiement
        if($this->loan->payment->balance_actual > 0 - ($this->loan->payment->balance_decouvert)) {
            // Transaction sur le compte de paiement
            CustomerTransactionHelper::create(
                'debit', 'sepa',
                'Prélèvement Remboursement Anticipé Pret Bancaire N°'.$this->loan->reference,
                $this->sepa->amount,
                $this->loan->wallet_payment_id);

            // Transaction sur le compte de pret
            CustomerTransactionHelper::create(
                'credit', 'sepa',
                'Remboursement Anticipé Pret Bancaire N°'.$this->loan->reference,
                $this->sepa->amount,
                $this->loan->customer_wallet_id);

            $this->sepa->update([
                'status' => 'processed'
            ]);

            if(CustomerLoanHelper::calcRestantDu($this->loan, false) == 0) {
                $this->loan->update([
                    'status' => 'terminated'
                ]);

                $this->loan->wallet->update([
                    'status' => 'closed'
                ]);
            }
        } else {
            $this->sepa->update([
                'status' => 'rejected'
            ]);
        }
    }
}
