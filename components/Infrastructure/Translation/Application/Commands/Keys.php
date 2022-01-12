<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;

class Keys extends Command
{
    use FilesTrait;

    protected $signature = 'translation:keys '.
        '{--path=* : File or directory} '.
        '{keys?* : The keys to locate}';

    protected $description = 'Dumps all the translation keys found in language files (resources/lang)';

    public function handle()
    {
        $paths = $this->option('path') ?: [resource_path('views')];

        foreach ($this->getFiles($paths) as $file) {
            foreach ($this->getKeysFromFile($file) as $key) {
                $this->line($key);
            }
        }
    }
}
