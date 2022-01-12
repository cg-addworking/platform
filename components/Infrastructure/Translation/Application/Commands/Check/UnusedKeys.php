<?php

namespace Components\Infrastructure\Translation\Application\Commands\Check;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;

class UnusedKeys extends Command
{
    use FilesTrait;

    protected $signature = 'translation:check:unused-keys '.
        '{--lang=* : Language} '.
        '{--path=* : File or directory to look for key usages} '.
        '{key?* : The key(s) to check}';

    protected $description = 'Checks unused translation keys';

    public function handle()
    {
        $langs = $this->option('lang') ?: [Config::get('app.locale')];
        $paths = $this->option('path') ?: Config::get('view.paths');
        $index = $this->getIndex($langs);

        if ($keys = $this->argument('key')) {
            $index = Arr::only($index, $keys);
        }

        $unused = array_diff(array_keys($index), $this->getKeysFromFiles($paths));
        sort($unused);

        foreach ($unused as $key) {
            $this->line($key);
        }

        return count($unused) ? 1 : 0;
    }
}
