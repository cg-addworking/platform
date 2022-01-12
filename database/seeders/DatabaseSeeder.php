<?php

namespace Database\Seeders;

use App\Utils\PostgresUtils;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    const LATEST_DUMP = 'megatron/dump.sql';

    public function run()
    {
        // --------------------------------------------------------------------
        // Seeding the database in production is forbidden!
        // --------------------------------------------------------------------

        if (config('app.env') == 'production') {
            return;
        }

        // --------------------------------------------------------------------
        // Dumping latest dump from production into local database
        // --------------------------------------------------------------------

        $shouldDownloadLatest = true;

        if (Storage::exists(self::LATEST_DUMP)) {
            $hoursPassed = Carbon::createFromTimestamp(Storage::lastModified(self::LATEST_DUMP))
                                ->diffInHours(Carbon::now('UTC'));
            $shouldDownloadLatest = $hoursPassed > 24;
        }

        if ($shouldDownloadLatest) {
            $this->command->info('Fetching latest dump from datalake to local filesystem...');
            Storage::put(self::LATEST_DUMP, Storage::disk('datalake')->get('latest.sql'));
        }

        $this->command->info('Drop \'pgsql\' database');
        Artisan::call('db:drop -n -f');
        $this->command->info('Importing latest dump to local database...');
        PostgresUtils::import('pgsql', storage_path('app') . '/' . self::LATEST_DUMP);
    }
}
