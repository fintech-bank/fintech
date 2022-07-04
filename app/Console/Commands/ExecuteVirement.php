<?php

namespace App\Console\Commands;

use App\Helper\CustomerTransferHelper;
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
        $virements = CustomerTransfer::query()->where('status', 'in_transit')->get();

        foreach ($virements as $virement) {
            switch ($virement->type) {
                case 'immediat':
                    return CustomerTransferHelper::executeTransfer($virement->id);
                    break;

                case 'differed':
                    return CustomerTransferHelper::initTransfer($virement->id);
                    break;

                default:
                    return CustomerTransferHelper::programTransfer($virement->id);
                    break;
            }
        }
    }
}
