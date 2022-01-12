<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Components\Infrastructure\Translation\Application\Commands\Traits\SerializeTrait;
use Illuminate\Console\Command;

class Fix extends Command
{
    use SerializeTrait, FilesTrait;

    protected $signature = 'translation:fix {--lang=fr}';

    protected $description = 'Fixes the translation files for given language';

    public function handle()
    {
        foreach ($this->getTranslationFiles($this->option('lang')) as $file) {
            $messages = require $file->getPathname();

            self::cleanup($messages);

            if (! file_put_contents($file->getPathname(), self::serialize($messages))) {
                throw new \RuntimeException("unable to write '{$file->getPathname()}'");
            }
        }

        return 0;
    }

    protected static function cleanup(array &$messages)
    {
        foreach ($messages as $key => &$value) {
            if (! is_string($key) || strlen($key) == 0) {
                unset($messages[$key]);
                continue;
            }

            if (is_array($value)) {
                self::cleanup($value);
            }
        }
    }
}
