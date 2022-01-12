<?php

namespace Components\Infrastructure\Megatron\Application\Commands;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerFactoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\ConfigurationUrlParser;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Run extends Command
{
    private const ERROR_DATABASE_IS_PROTECTED=101;
    private const ERROR_DATABASE_NOT_FOUND=102;
    private const ERROR_TRANSFORM_MISSING_ID=103;
    private const ERROR_CONFIGURATION_INVALID=104;
    private const ERROR_DISK_INVALID=105;
    private const ERROR_MISSING_DUMP=106;
    private const ERROR_STORAGE_WRITE_ERROR=107;
    private const ERROR_STORAGE_COPY_ERROR=108;

    protected $signature = 'megatron:run'.
        '{database : The database to use}'.
        '{--f|force : Force run on production environment}'.
        '{--d|dry-run : Dry Run}'.
        '{--skip-transform : Skip transform}'.
        '{--skip-truncate : Skip truncate}'.
        '{--skip-vacuum : Skip VACUUM}'.
        '{--skip-dump : Skip dump}'.
        '{--skip-send : Skip send}';

    protected $description = 'Transforms, truncate, and purge database';

    protected $connectionFactory;

    protected $connection;

    protected $transformerFactory;

    public function __construct(
        ConnectionFactory $connection,
        TransformerFactoryInterface $transformer
    ) {
        parent::__construct();

        $this->connectionFactory  = $connection;
        $this->transformerFactory = $transformer;
    }

    public function handle()
    {
        try {
            if (! $this->option('force') && ! $this->warning()) {
                return 0;
            }

            $connection = $this->getConnection();
            $database   = $this->argument('database');
            $filepath   = $this->relative($this->getFilepath());
            $disk       = Config::get('megatron.datalake.disk');

            if (! $this->option('skip-transform')) {
                foreach (array_keys(Config::get('megatron.transformers')) as $table) {
                    $this->info("Processing {$table}...");
                    $this->transform($table);
                    $this->comment("Table {$table} processed");
                }
            }

            if (! $this->option('skip-truncate')) {
                foreach (Config::get('megatron.truncate') as $table) {
                    $this->info("Truncating table {$table}...");
                    $this->truncate($table);
                    $this->comment("Table {$table} truncated");
                }
            }

            if (! $this->option('skip-vacuum')) {
                $this->info("Running query 'VACUUM FULL'...");
                $this->vacuum($table);
                $this->comment("Query 'VACCUM FULL' ran");
            }

            if (! $this->option('skip-dump')) {
                $this->info("Dumping {$database}...");
                $this->dump();
                $this->comment("Database {$database} dumped in {$filepath}");
            }

            if (! $this->option('skip-send')) {
                $this->info("Sending {$filepath} to {$disk}...");
                $this->send();
                $this->comment("Dump {$filepath} sent to {$disk}");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return $e->getCode() ?: 1;
        }
    }

    // ------------------------------------------------------------------------
    // Pipes
    // ------------------------------------------------------------------------

    protected function transform($table)
    {
        $transformer = $this->transformerFactory->getTransformer($table);

        $query = $this->getSelectQuery($table);
        $count = $query->count();

        foreach ($query->cursor() as $num => $item) {
            $item = (array) $item;

            if (empty($item['id'])) {
                throw new \RuntimeException(
                    "Unable to transform {$table}: ".
                    "unable to process an item without id",
                    self::ERROR_TRANSFORM_MISSING_ID
                );
            }

            $values = $transformer->transform($item);

            if ($this->getOutput()->isVerbose()) {
                $this->getOutput()->write(vsprintf("\r%s %s:%s [%d/%d:%d%%]", [
                    $values ? "Updating" : "Ignoring", $table,
                    $item['id'], $num + 1, $count, (($num + 1) / $count) * 100,
                ]));
            }

            if (empty($values)) {
                continue;
            }

            if ($this->option('dry-run')) {
                continue;
            }

            $this->getConnection()
                ->table($table)
                ->where('id', $item['id'])
                ->update($values);
        }

        if ($this->getOutput()->isVerbose()) {
            $this->line('');
        }
    }

    protected function truncate(string $table)
    {
        if ($this->option('dry-run')) {
            return;
        }

        $this->getConnection()->table($table)->truncate();
    }

    protected function vacuum(string $table)
    {
        if ($this->option('dry-run')) {
            return;
        }

        $this->getConnection()->statement('VACUUM FULL');
    }

    protected function dump(): bool
    {
        $config  = $this->getDatabaseConfig();
        $return  = 0;
        $command = sprintf(
            "PGPASSWORD=%s pg_dump -U %s -h %s -x -O -f %s %s",
            escapeshellarg($config['password']),
            escapeshellarg($config['username']),
            escapeshellarg($config['host']),
            escapeshellarg($this->getFilepath()),
            escapeshellarg($config['database'])
        );

        if ($this->getOutput()->isVerbose()) {
            $this->comment("Command: {$command}");
        }

        if (! $this->option('dry-run')) {
            passthru($command, $return);
        }

        return $return == 0;
    }

    protected function send()
    {
        if ($this->option('dry-run')) {
            return;
        }

        $disk = Config::get('megatron.datalake.disk');
        $file = $this->getFilepath();

        if (! Config::has("filesystems.disks.{$disk}")) {
            throw new \InvalidArgumentException(
                "Cannot store dump to disk: disk {$disk} doesn't exists",
                self::ERROR_DISK_INVALID
            );
        }

        if (! file_exists($file)) {
            throw new \RuntimeException(
                "Cannot store dump to disk: file {$file} doesn't exists",
                self::ERROR_MISSING_DUMP
            );
        }

        $storage  = Storage::disk($disk);
        $latest   = "latest.sql";
        $backup   = basename($file);

        if (! $storage->putFileAs('/', new File($file), $latest)) {
            throw new \RuntimeException(
                "Cannot store dump to disk: unable to send {$file} to {$disk} as {$latest}",
                self::ERROR_STORAGE_WRITE_ERROR
            );
        }

        if (! $storage->exists($backup) && ! $storage->copy($latest, $backup)) {
            throw new \RuntimeException(
                "Cannot store dump to disk: unable to copy {$latest} to {$backup}",
                self::ERROR_STORAGE_COPY_ERROR
            );
        }
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    protected function getColumns(string $table): array
    {
        return $this
            ->getConnection()
            ->getDoctrineSchemaManager()
            ->listTableDetails($table)
            ->getColumns();
    }

    protected function getColumnsToSelect(string $table): array
    {
        if (! $excluded = Config::get("megatron.exclude.{$table}")) {
            return ["*"];
        }

        return Collection::wrap($this->getColumns($table))
            ->keys()
            ->filter(fn($table) => !in_array($table, $excluded))
            ->toArray();
    }

    protected function getConnection(): Connection
    {
        if ($this->connection) {
            return $this->connection;
        }

        $database = $this->argument('database');

        if (in_array($database, Config::get('megatron.protected')) && ! $this->option('force')) {
            throw new \InvalidArgumentException(
                "Cannot establish a database: database {$database} is protected",
                self::ERROR_DATABASE_IS_PROTECTED
            );
        }

        if (Config::has("database.connections.{$database}")) {
            return $this->connection = DB::connection($database);
        }

        if (env($database, false)) {
            return $this->connection = $this->connectionFactory->make(
                (new ConfigurationUrlParser)->parseConfiguration(env($database))
            );
        }

        throw new \InvalidArgumentException(
            "Cannot establish a database connection: {$database} is neither ".
            "an existing database in config/database.php nor an existing ".
            "environment variable",
            self::ERROR_DATABASE_NOT_FOUND
        );
    }

    protected function getDatabaseConfig(): array
    {
        $database = $this->argument('database');

        if (in_array($database, Config::get('megatron.protected')) && ! $this->option('force')) {
            throw new \InvalidArgumentException(
                "Cannot dump database: database {$database} is protected",
                self::ERROR_DATABASE_IS_PROTECTED
            );
        }

        // $database is a environment variable
        if (env($database, false)) {
            return $this->validateDatabaseConfig(
                (new ConfigurationUrlParser)->parseConfiguration(
                    env($database)
                )
            );
        }

        // $database is configured in config/database.php using an URL
        if (Config::has("database.connections.{$database}.url")) {
            return $this->validateDatabaseConfig(
                (new ConfigurationUrlParser)->parseConfiguration(
                    Config::get("database.connections.{$database}.url")
                )
            );
        }

        // $database is configured in config/database.php using an ARRAY
        if (Config::has("database.connections.{$database}")) {
            return $this->validateDatabaseConfig(
                Config::get("database.connections.{$database}")
            );
        }

        // couldn't find a configuration for that name...
        throw new \InvalidArgumentException(
            "Cannot dump database: {$database} is neither ".
            "an existing database in config/database.php nor an existing ".
            "environment variable",
            self::ERROR_DATABASE_NOT_FOUND
        );
    }

    protected function getFilepath(): string
    {
        return  sys_get_temp_dir() . DIRECTORY_SEPARATOR . str_replace(
            ['%date%', '%env%'],
            [date('Y-m-d'), $this->laravel->environment()],
            Config::get('megatron.datalake.filename')
        );
    }

    protected function getSelectQuery(string $table): Builder
    {
        $query = $this->getConnection()
            ->table($table)
            ->select(...$this->getColumnsToSelect($table));

        if ($this->getOutput()->isVerbose()) {
            $this->comment("Query: {$query->toSql()}");
        }

        return $query;
    }

    // ------------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------------

    protected function relative(string $path): string
    {
        return Str::after(
            is_file($path) ? realpath($path) : $path,
            getcwd() . DIRECTORY_SEPARATOR
        );
    }

    protected function validateDatabaseConfig(array $config): array
    {
        foreach (['password', 'username', 'host', 'database'] as $var) {
            if (empty($config[$var])) {
                throw new \InvalidArgumentException(
                    "Cannot dump database: '{$var}' missing in database configuration",
                    self::ERROR_CONFIGURATION_INVALID
                );
            }
        }

        return $config;
    }

    protected function warning(): bool
    {
        $config = $this->getDatabaseConfig();
        $output = $this->getOutput();

        $output->writeln("Environment....: {$this->laravel->environment()}");
        $output->writeln("Host...........: <fg=green>{$config['host']}</>");
        $output->writeln("Database.......: <fg=yellow>{$config['database']}</>");
        $output->writeln("Username.......: {$config['username']}");
        $output->writeln("Password.......: {$config['password']}");

        return $this->confirm("This command will change database entries permanently. Continue?");
    }
}
