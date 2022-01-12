<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class Dump extends Command
{
    use FilesTrait;

    protected $signature = 'translation:dump '.
        '{--langs=* : Languages} '.
        '{--keys-only : Only dump available keys} '.
        '{--filter= : Only dump key that matches the given filter} '.
        '{keys?* : The keys to dump}';

    protected $description = 'Dumps all the translation keys found in language files (resources/lang)';

    public function handle()
    {
        $langs  = $this->option('langs') ?: Config::get('app.available_locales', []);
        $index  = $this->getIndex($langs);

        if ($filter = $this->option('filter')) {
            $index = $this->filter($index, $filter);
        }

        if ($keys = $this->argument('keys')) {
            $index = Arr::only($index, $keys);
        }

        if ($this->option('keys-only')) {
            foreach ($index as $key => $val) {
                $this->line($key);
            }

            return 0;
        }

        $this->line(json_encode($index, JSON_PRETTY_PRINT));
        return 0;
    }

    protected static function filter(array $index, string $filter): array
    {
        $filter = static::compileRegex($filter);

        return array_filter($index, fn($val, $key) => preg_match("/{$filter}/", $key), ARRAY_FILTER_USE_BOTH);
    }

    protected static function compileRegex(string $filter): string
    {
        return sprintf('.*%s.*', str_replace(['/', '.'], ['\/', '\.'], $filter));
    }
}
