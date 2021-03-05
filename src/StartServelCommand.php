<?php

namespace Servel;

use Illuminate\Console\Command;

final class StartServelCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'servel {action : Command to execute [start, stop, restart, reload, status, connections] }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start all defined servers';

    /**
     * Start all servers.
     *
     * @return void
     */
    public function handle()
    {
        $version = Servel::VERSION;

        $this->info("Servel {$version} by Gregori Piñeres and contributors.");

        $servel = new Servel;

        $servel->start();
    }
}
