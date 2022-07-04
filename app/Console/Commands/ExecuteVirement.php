<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerTransferHelper;
use App\Helper\CustomerWalletHelper;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use Illuminate\Console\Command;

class ExecuteVirement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:execute {call : Commande à executer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute une commande relative à la gestion bancaire automatique';

    /**
     * Execute the console command.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|void
     */
    public function handle()
    {
        switch ($this->argument('call')) {
            case 'virement':
                    return $this->executeVirements();
                break;

            default: return $this->executeVirements();
        }
    }

    private function executeVirements()
    {
        $virements = CustomerTransfer::query()->where('status', 'in_transit')->orWhere('status', 'pending')->get();

        foreach ($virements as $virement) {
            $transaction = CustomerTransaction::find($virement->transaction_id);
            switch ($virement->type) {
                case 'immediat':
                    // Vérifie que le solde est disponible
                    if($virement->amount <= CustomerWalletHelper::getSoldeRemaining($transaction->wallet)) {
                        // Met à jour la transaction
                        CustomerTransactionHelper::updated($transaction);

                        // Met à jour le transfer
                        $virement->status = 'paid';
                        $virement->save();
                    } else {
                        CustomerTransactionHelper::deleteTransaction($transaction);

                        $virement->status = 'failed';
                        $virement->save();
                    }
                    break;

                case 'differed':
                    if($virement->transfer_date->startOfDay() == now()->startOfDay()) {
                        // Met à jour la transaction
                        CustomerTransactionHelper::updated($transaction);

                        // Met à jour le transfer
                        $virement->status = 'paid';
                        $virement->save();
                    }
                    break;

                default:
                    if($transaction->updated_at->startOfDay() == now()->startOfDay()) {
                        // Met à jour la transaction
                        CustomerTransactionHelper::updated($transaction);

                        // Met à jour le transfer
                        $virement->status = 'paid';
                        $virement->save();
                    }
                    break;
            }
        }

    }
}
