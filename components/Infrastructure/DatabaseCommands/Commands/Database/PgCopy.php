<?php

namespace Components\Infrastructure\DatabaseCommands\Commands\Database;

use Illuminate\Console\Command;

class PgCopy extends Command
{
    protected $signature = 'db:pg-copy {--f|force} {remote}';

    protected $description = 'Import remote PostgreSQL database into local one';

    public function handle()
    {
        // do NOT run this command in production
        if (config('app.env') == 'production') {
            $this->error("Application in production");
            return;
        }

        if (!$this->option('force') && !$this->confirm('Do you really wish to run this command?')) {
            return;
        }

        // put the application into maintenance mode
        $this->call('down');

        // drop all tables in the database
        $this->call('db:drop', ['--force' => true]);

        $local  = escapeshellarg(env('DATABASE_URL'));
        $remote = escapeshellarg($this->argument('remote')); // you'll find it under settings of the app you're cloning

        // reset the database using production's data
        passthru("pg_dump {$remote} | psql {$local} && composer install", $return);

        // run the migrations
        $this->call('migrate', ['--force' => true]);

        // bring the application out of maintenance mode
        $this->call('up');
    }
}
