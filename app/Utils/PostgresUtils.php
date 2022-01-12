<?php

namespace App\Utils;

use RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;

class PostgresUtils
{
    const PG_PASS_FILE = '/tmp/pgpass';

    public static function import(string $database, string $filename): bool
    {
        if (! $config = Config::get("database.connections.{$database}")) {
            throw new RuntimeException("no such database $database");
        }

        $process = new Process([
            'psql',
            '-U', $config['username'],
            '-h', $config['host'],
            '-d', $config['database'],
            '-f', $filename
        ], null, ['PGPASSFILE' => self::pgpass()]);
        $process->setTimeout(3600);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }

        return true;
    }

    protected static function pgpass(): string
    {
        $contents = "";

        foreach (Config::get('database.connections') as $database) {
            if ($database['driver'] == 'pgsql') {
                $contents .= vsprintf(
                    "%s:%s:%s:%s:%s\n",
                    Arr::only($database, ['host', 'port', 'database', 'username', 'password'])
                );
            }
        }

        file_put_contents(self::PG_PASS_FILE, $contents);
        chmod(self::PG_PASS_FILE, 0600);

        return self::PG_PASS_FILE;
    }
}
