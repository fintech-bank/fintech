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
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('call')) {
            case 'virement':
                    $this->executeVirements();
                break;
        }
    }

    private function executeVirements()
    {
        $virements = CustomerTransfer::query()->where('status', 'in_transit')->get();

        foreach ($virements as $virement) {
            switch ($virement->type) {
                case 'immediat':
                    CustomerTransferHelper::executeTransfer($virement->id);
                    break;

                case 'differed':
                    CustomerTransferHelper::initTransfer($virement->id);
                    break;

                default:
                    CustomerTransferHelper::programTransfer($virement->id);
                    break;
            }
        }
    }
}
