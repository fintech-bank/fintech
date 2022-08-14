<?php

namespace App\Console\Commands;

use App\Helper\CustomerHelper;
use App\Helper\CustomerMobilityHelper;
use App\Models\Customer\CustomerMobility;
use App\Notifications\Customer\Automate\GetMobilityBankEndNotification;
use App\Services\BankFintech;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MobilityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobility {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestion de la vie des mobilités bancaires';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'bank_end':
                return $this->bankEnd();

            case 'creditor_start':
                return $this->creditorStart();

            case 'creditor_end':
                return $this->creditorEnd();

            case 'close':
                return $this->close();
        }
    }

    private function bankEnd()
    {
        $mobilities = CustomerMobility::all();
        $bank = new BankFintech();
        $arr = [];
        foreach ($mobilities as $mobility) {
            if($mobility->status == 'bank_start' && Carbon::createFromTimestamp(strtotime($mobility->start))->addDays(5)->startOfDay() == now()->startOfDay()) {
                $call = $bank->callTransferDoc($mobility->customer, $mobility->customer->agency, $mobility->mandate);

                foreach ($call->prlv as $prlv) {
                    $mobility->prlvs()->create([
                        'uuid' => $prlv->uuid,
                        'creditor' => $prlv->creditor,
                        'number_mandate' => $prlv->number_mandate,
                        'amount' => $prlv->amount,
                        'customer_mobility_id' => $mobility->id
                    ]);
                }

                foreach ($call->vir_incoming as $vir) {
                    $mobility->incomings()->create([
                        'uuid' => $vir->uuid,
                        'amount' => $vir->amount,
                        'reference' => $vir->reference,
                        'reason' => $vir->reason,
                        'type' => $vir->type,
                        'transfer_date' => $vir->transfer_date ? Carbon::createFromTimestamp(strtotime($vir->transfer_date)) : null,
                        'recurring_start' => $vir->recurring_start ? Carbon::createFromTimestamp(strtotime($vir->recurring_start)) : null,
                        'recurring_end' => $vir->recurring_end ? Carbon::createFromTimestamp(strtotime($vir->recurring_end)) : null,
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                foreach ($call->vir_outgoing as $vir) {
                    $mobility->outgoings()->create([
                        'uuid' => $vir->uuid,
                        'amount' => $vir->amount,
                        'reference' => $vir->reference,
                        'reason' => $vir->reason,
                        'transfer_date' => Carbon::createFromTimestamp(strtotime($vir->transfer_date)),
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                foreach ($call->cheques as $cheque) {
                    $mobility->cheques()->create([
                        'number' => $cheque->number,
                        'amount' => $cheque->amount,
                        'date_enc' => $cheque->date_enc->date,
                        'creditor' => $cheque->creditor,
                        'file_url' => config('domain.bank').'/storage/'.$mobility->mandate.'/check/'.$cheque->number.'.pdf',
                        'customer_mobility_id' => $mobility->id,
                    ]);
                }

                $mobility->update([
                    'status' => 'bank_return',
                    'comment' => CustomerMobilityHelper::getStatus('bank_return', 'comment'),
                    'updated_at' => now()
                ]);

                $mobility->customer->user->notify(new GetMobilityBankEndNotification($mobility));
                $arr[] = [
                    'mandate' => $mobility->mandate,
                    'customer' => CustomerHelper::getName($mobility->customer)
                ];
            }
        }

        $this->table(['Mandat', "Client"], $arr);
        return 0;
    }
    private function creditorStart()
    {
        $mobilities = CustomerMobility::all();
        $arr = [];
        foreach ($mobilities as $mobility) {
            if($mobility->status == 'bank_return' && CustomerMobilityHelper::documentIsAllValid($mobility)) {
                $mobility->update([
                    'status' => 'creditor_start',
                    'comment' => CustomerMobilityHelper::getStatus('creditor_start', 'comment'),
                    "updated_at" => now()
                ]);

                $mobility->customer->user->notify(new GetMobilityBankEndNotification($mobility));
                $arr[] = [
                    'mandate' => $mobility->mandate,
                    'customer' => CustomerHelper::getName($mobility->customer)
                ];
            }
        }

        $this->table(['Mandat', "Client"], $arr);
        return 0;
    }

    private function creditorEnd()
    {
        $mobilities = CustomerMobility::all();
        $arr = [];
        foreach ($mobilities as $mobility) {
            if($mobility->status == 'creditor_start' && $mobility->updated_at->addDays(5)->startOfDay() == now()->startOfDay()) {
                $mobility->update([
                    'status' => 'creditor_end',
                    'comment' => CustomerMobilityHelper::getStatus('creditor_end', 'comment'),
                    "updated_at" => now()
                ]);

                $mobility->customer->user->notify(new GetMobilityBankEndNotification($mobility));
                $arr[] = [
                    'mandate' => $mobility->mandate,
                    'customer' => CustomerHelper::getName($mobility->customer)
                ];
            }
        }

        $this->table(['Mandat', "Client"], $arr);
        return 0;
    }

    private function close()
    {
        $mobilities = CustomerMobility::all();
        $arr = [];
        foreach ($mobilities as $mobility) {
            if($mobility->status == 'creditor_end') {
                $mobility->update([
                    'status' => 'terminate',
                    'comment' => CustomerMobilityHelper::getStatus('terminate', 'comment'),
                    "updated_at" => now()
                ]);

                $mobility->customer->user->notify(new GetMobilityBankEndNotification($mobility));
                $arr[] = [
                    'mandate' => $mobility->mandate,
                    'customer' => CustomerHelper::getName($mobility->customer)
                ];
            }
        }

        $this->table(['Mandat', "Client"], $arr);
        return 0;
    }
}
