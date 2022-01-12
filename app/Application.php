<?php

namespace App;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    public function __construct($basePath = null)
    {
        $this->registerHerokuDatabase();
        $this->registerHerokuRedis();

        parent::__construct($basePath);
    }

    /**
     * Heroku Postgres
     *
     * Translates the DATABASE_URL environment setting into several (more
     * conventionnal for Laravel) environment settings DB_CONNECTION, DB_HOST,
     * DB_PORT, DB_USERNAME, DB_PASSWORD, and DB_DATABASE.
     *
     * @return void
     */
    protected function registerHerokuDatabase()
    {
        if (! $url = getenv('DATABASE_URL')) {
            return;
        }

        $url = (parse_url($url) ?: []) + [
            'scheme' => null, 'host' => null, 'port' => null,
            'user'   => null, 'pass' => null, 'path' => null
        ];

        if ($url['scheme'] == 'postgres') {
            putenv("DB_CONNECTION=pgsql");
            $url['host'] && putenv("DB_HOST={$url['host']}");
            $url['port'] && putenv("DB_PORT={$url['port']}");
            $url['user'] && putenv("DB_USERNAME={$url['user']}");
            $url['pass'] && putenv("DB_PASSWORD={$url['pass']}");
            $url['path'] && putenv("DB_DATABASE=" . substr($url['path'], 1));
        }
    }

    /**
     * Heroku Redis
     *
     * Translates the REDIS_URL environment setting into several (more
     * conventionnal for Laravel) environment settings REDIS_HOST,
     * REDIS_PASSWORD, and REDIS_PORT.
     *
     * @return void
     */
    protected function registerHerokuRedis()
    {
        if (! $url = getenv('REDIS_URL')) {
            return;
        }

        $url = (parse_url($url) ?: []) + [
            'scheme' => null, 'host' => null, 'port' => null,
            'user'   => null, 'pass' => null, 'path' => null
        ];

        if ($url['scheme'] == 'redis') {
            putenv("CACHE_DRIVER=redis");
            $url['host'] && putenv("REDIS_HOST={$url['host']}");
            $url['port'] && putenv("REDIS_PORT={$url['port']}");
            $url['pass'] && putenv("REDIS_PASSWORD={$url['pass']}");
        }
    }
}
