<?php

namespace Components\Infrastructure\DatabaseCommands\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Tables extends Command
{
    protected $signature = 'db:tables {--database=} {--with-row-count}';

    protected $description = 'Lists available datbase tables';

    public function handle()
    {
        $connection = DB::connection($this->option('database'));
        $schema = $connection->getSchemaBuilder();

        // @see Doctrine\DBAL\Schema\AbstractSchemaManager
        $tables = $connection->getDoctrineSchemaManager()->listTableNames();
        sort($tables);

        if (empty($tables)) {
            $this->error("Database is empty");
            return;
        }

        return $this->option('with-row-count')
            ? $this->withRowsCount($connection, $tables)
            : $this->withoutRowsCount($tables);
    }

    public function withoutRowsCount(array $tables)
    {
        foreach ($tables as $tablename) {
            $this->line($tablename);
        }
    }

    public function withRowsCount($connection, array $tables)
    {
        $headers = ['Tablename', 'Rows'];

        foreach ($tables as $table) {
            $counts[] = [$table, $connection->table($table)->count()];
        }

        $this->table($headers, $counts);
    }
}
