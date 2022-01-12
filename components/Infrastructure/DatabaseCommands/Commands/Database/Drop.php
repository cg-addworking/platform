<?php

namespace Components\Infrastructure\DatabaseCommands\Commands\Database;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\PostgresConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Drop extends Command
{
    protected $signature = 'db:drop {--f|force} {--database=}';

    protected $description = 'Drop tables in the given (or default) database';

    public function handle()
    {
        $connection = DB::connection($this->option('database'));
        $schema = $connection->getSchemaBuilder();

        // @see Doctrine\DBAL\Schema\AbstractSchemaManager
        $tables = $connection->getDoctrineSchemaManager()->listTableNames();

        if (empty($tables)) {
            $this->info("Database is empty");
            return;
        }

        if (! $this->option('force')) {
            $this->info(count($tables) . " tables will be destroyed. This operation cannot be undone.");

            if (! $this->confirm('Do want to continue?')) {
                return;
            }
        }

        try {
            $schema->disableForeignKeyConstraints();

            $connection->transaction(function () use ($connection, $schema, $tables) {
                foreach ($tables as $table) {
                    if ($table == 'sqlite_sequence') {
                        continue;
                    }

                    if ($connection instanceof PostgresConnection) {
                        $connection->statement("DROP TABLE IF EXISTS {$table} CASCADE");
                    } else {
                        $schema->dropIfExists($table);
                    }
                }
            });
        } catch (Exception $e) {
            throw $e;
        } finally {
            $schema->enableForeignKeyConstraints();
        }
    }
}
