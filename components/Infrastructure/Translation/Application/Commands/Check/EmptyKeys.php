<?php

namespace Components\Infrastructure\Translation\Application\Commands\Check;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;

class EmptyKeys extends Command
{
    use FilesTrait;

    protected $signature = 'translation:check:empty-keys '.
        '{--lang=* : Language} '.
        '{key?* : The key(s) to check}';

    protected $description = 'Checks empty translation keys';

    public function handle()
    {
        $langs = $this->option('lang') ?: [Config::get('app.locale')];
        $index = $this->getIndex($langs);

        if ($keys = $this->argument('key')) {
            $index = Arr::only($index, $keys);
        }

        if (empty($empty = $this->getEmptyKeys($index, $langs))) {
            return 1;
        }

        foreach ($empty as $key) {
            $this->line($key);
        }

        return 1;
    }

    protected function getEmptyKeys(array $index, array $langs): array
    {
        $keys = [];

        foreach ($index as $key => $values) {
            if (implode('', array_map('trim', $values)) == '') {
                $keys[] = $key;
            }
        }

        return $keys;
    }
}
