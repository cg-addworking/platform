<?php

namespace App\Console\Commands\Addworking\User;

use App\Models\Addworking\User\UserLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurgeUserLog extends Command
{
    protected $signature = 'addworking:user:purge-logs {number=15 : Number of days}';

    protected $description = 'Purge UserLog entries older than <x> days';

    public function handle()
    {
        $number = intval($this->argument('number'));

        $deleted = UserLog::whereDate(
            'created_at',
            '<=',
            Carbon::now()->subDays($number)->format('Y-m-d')
        )->forceDelete();

        $deleted
            ? $this->info('Logs have been deleted successfully.')
            : $this->error('There are no user logs to purge.');
    }
}
