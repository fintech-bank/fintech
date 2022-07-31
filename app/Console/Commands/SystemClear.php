<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('clear-compiled');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('event:clear');
        $this->call('horizon:clear');
        $this->call('log-viewer:clear');
        $this->call('optimize:clear');
        $this->call('queue:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('auth:clear-resets');
        $this->call('schedule:clear-cache');

        return 0;
    }
}
