<?php

namespace Components\Infrastructure\DatabaseCommands\Commands\Database;

use Illuminate\Console\Command;

class Reset extends Command
{
    protected $signature = 'db:reset {--seed}';

    protected $description = 'Resets the database and run migrations';

    public function handle()
    {
        // do NOT run this command in production
        if (config('app.env') == 'production') {
            $this->error("Application in production");
            return;
        }

        // put the application into maintenance mode
        $this->call('down');

        // drop all tables in the database
        $this->call('db:drop', ['--force' => true]);

        // run the migrations
        $this->call('migrate', ['--force' => true, '--seed' => $this->option('seed')]);

        // bring the application out of maintenance mode
        $this->call('up');
    }
}
