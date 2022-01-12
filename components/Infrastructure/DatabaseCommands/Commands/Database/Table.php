<?php

namespace Components\Infrastructure\DatabaseCommands\Commands\Database;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Illuminate\Console\Command;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PDO;

class Table extends Command
{
    protected $signature = 'db:table {table?} {--database=}';

    protected $description = "Show given table's structure";

    public function handle()
    {
        try {
            $tablename       = $this->getTablename();
            $connection      = DB::connection($this->option('database'));
            $manager         = $connection->getDoctrineSchemaManager();
            $foreign_keys    = $this->getTableForeignKeys($manager, $tablename);
            $indices         = $this->getTableIndices($manager, $tablename);
            $table_structure = $this->getTableStructure($manager, $tablename);
        } catch (TableNotFoundException $e) {
            $this->error("No such table $tablename");
            $this->output->writeln("\nUse <fg=green>php artisan db:tables</> to list available tables");
            return 1;
        }

        if ($connection instanceof SQLiteConnection) {
            $this->output->writeln(
                "<bg=yellow;fg=black>Reading foreign key definition from an SQLite database is not supported</>"
            );
        }

        $this->line($tablename);
        $this->table(['PK', 'Name', 'Type', 'Default', 'Null', 'Foreign Key'], $table_structure);
    }

    protected function getTablename(): string
    {
        Artisan::call('db:tables');
        $available_tables = explode("\n", Artisan::output());

        if ($table = $this->argument('table')) {
            if (in_array($table, $available_tables)) {
                return $table;
            }

            $table = $this->findClosest($table, $available_tables, $options);

            if ($this->confirm("Did you mean {$table}?", "yes")) {
                return $table;
            }

            return $this->choice("Tables that match your search:", $options);
        }

        return $this->anticipate("Table", $available_tables);
    }

    protected function getTableForeignKeys($manager, string $tablename): array
    {
        $foreign_keys = [];
        foreach ($manager->listTableForeignKeys($tablename) as $fk) {
            foreach ($fk->getColumns() as $i => $column) {
                $foreign_keys[$column] = sprintf('%s.%s', $fk->getForeignTableName(), $fk->getForeignColumns()[$i]);
            }
        }

        return $foreign_keys;
    }

    protected function getTableIndices($manager, string $tablename): array
    {
        $indices = ['unique' => [], 'primary' => []];
        foreach ($manager->listTableIndexes($tablename) as $index) {
            foreach ($index->getColumns() as $i => $column) {
                if ($index->isUnique()) {
                    $indices['unique'][$column] = true;
                }

                if ($index->isPrimary()) {
                    $indices['primary'][$column] = true;
                }
            }
        }

        return $indices;
    }

    protected function getTableStructure($manager, string $tablename): array
    {
        $table_structure = [];
        foreach ($manager->listTableDetails($tablename)->getColumns() as $column => $definition) {
            $table_structure[] = [
                'pk'      => !empty($indices['primary'][$column]) ? 'yes' : '',
                'name'    => $column,
                'type'    => $definition->getType()->getName(),
                'deault'  => $definition->getDefault(),
                'null'    => $definition->getNotnull() ? 'yes' : '',
                'foreign' => $foreign_keys[$column] ?? ''
            ];
        }

        return $table_structure;
    }

    /**
     * Return the string of characters corresponding most to the searched string.
     *
     * e.g. ngram('Paris', 3) > [__P, _Pa, Par, ari, ris, is_, s__]
     *
     * @param  string $str
     * @param  int    $length
     * @return array
     */
    protected function ngram(string $str, int $length = 3): array
    {
        if (empty($str)) {
            return [];
        }

        $ngram = [];
        $str = str_repeat(' ', $length - 1) . $str;
        for ($i = 0; $i < strlen($str); $i++) {
            $ngram[] = trim(substr($str, $i, $length));
        }

        return $ngram;
    }

    protected function findClosest(string $str, array $options, array &$results = null): string
    {
        $max     = null;
        $found   = null;
        $ngram   = ngram($str, 5);
        $results = [];

        foreach ($options as $option) {
            $proximity = count($this->arrayIntersect($ngram, ngram($option, 5)));

            if (is_null($max) || $proximity > $max) {
                $found = $option;
                $max = $proximity;
                $results = [$option];
            } elseif ($proximity == $max) {
                $results[] = $option;
            }
        }

        return $found;
    }

    protected function arrayIntersect(array $arr1, array $arr2): array
    {
        $arr1 = array_values($arr1);
        $arr2 = array_values($arr2);

        $result = [];

        foreach ($arr1 as $value) {
            if (false !== $pos = array_search($value, $arr2)) {
                $result[] = $value;
                unset($arr2[$pos]);
            }
        }

        return $result;
    }
}
