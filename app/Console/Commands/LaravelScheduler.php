<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LaravelScheduler extends Command
{
    protected $signature = 'schedule:laravel';

    protected $description = 'Call the laravel scheduler every minute.';

    public function handle()
    {
        while (true) {
            $this->info('Calling scheduler');
          
            $this->call('schedule:run');

            sleep(60);
        }
    }
}
