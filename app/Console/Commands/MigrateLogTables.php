<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateLogTables extends Command
{
    protected $signature = 'make:log-tables-migrate';
    protected $description = 'Migrate log tables';

    const CONNECTION = 'pgsql_log';

    public function handle()
    {
        $this->createAddworkingUserLogsTable();
        $this->createQueueLogsTable();

        $this->info('task finished');
    }

    protected function createAddworkingUserLogsTable()
    {
        if (! Schema::connection(self::CONNECTION)->hasTable('addworking_user_logs')) {
            Schema::connection(self::CONNECTION)->create('addworking_user_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('user_id');
                $table->string('route');
                $table->string('url');
                $table->string('http_method');
                $table->ipAddress('ip')->nullable();
                $table->json('input')->nullable();
                $table->json('headers')->nullable();
                $table->boolean('impersonating');

                $table->timestamps();
                $table->softDeletes();
            });

            $this->info('table addworking_user_logs created');
        } else {
            $this->warn('table addworking_user_logs already exists');
        }
    }

    protected function createQueueLogsTable()
    {
        if (! Schema::connection(self::CONNECTION)->hasTable('queue_logs')) {
            Schema::connection(self::CONNECTION)->create('queue_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('job_id');
                $table->string('job_name');
                $table->string('queue_name');
                $table->json('metadata');
                $table->string('action_type');
                $table->longText('exception')->nullable();
                $table->dateTime('created_at');
            });

            $this->info('table queue_logs created');
        } else {
            $this->warn('table queue_logs already exists');
        }
    }
}
