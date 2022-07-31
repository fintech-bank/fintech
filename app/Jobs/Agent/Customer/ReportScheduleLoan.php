<?php

namespace App\Jobs\Agent\Customer;

use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportScheduleLoan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $loan;

    public $datePrlv;

    /**
     * Create a new job instance.
     *
     * @param $loan
     * @param $datePrlv
     */
    public function __construct($loan, $datePrlv)
    {
        //
        $this->loan = $loan;
        $this->datePrlv = $datePrlv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        CustomerSepa::query()
            ->where('creditor', config('app.name'))
            ->where('status', 'waiting')
            ->where('updated_at', $this->datePrlv)
            ->delete();
    }
}
