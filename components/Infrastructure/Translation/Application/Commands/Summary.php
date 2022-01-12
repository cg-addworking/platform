<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class Summary extends Command
{
    use FilesTrait;

    protected $signature = 'translation:summary';

    protected $description = 'Gives an overview of the translations in the app';

    public function handle()
    {
        foreach ($this->getLanguages() as $lang) {
            $stats[$lang] = [
                'lang' => $lang,
                'files' => 0,
                'keys' => 0,
                'empty' => 0,
                'complete' => 0,
            ];

            foreach ($this->getTranslationFiles($lang) as $file) {
                $messages = Arr::dot(require $file->getPathname());

                $empty = fn($val) => empty($val) || strlen(trim($val)) == 0;

                $stats[$lang]['files'] ++;
                $stats[$lang]['keys']  += count($messages);
                $stats[$lang]['empty'] += count(array_filter($messages, $empty));
            }

            $stats[$lang]['complete'] = sprintf("%3d%%", 100 * (1 - $stats[$lang]['empty'] / $stats[$lang]['keys']));
        }

        usort($stats, fn($a, $b) => $a['keys'] <=> $b['keys']);

        $this->table(['Lang', 'Files', 'Keys', 'Empty', 'Done'], $stats);

        return 0;
    }

    public function getLanguages(): \Generator
    {
        $exclude = fn($file) => $file->isDir() && ! $file->isDot() && $file->getBasename() != 'vendor';

        $it = new \DirectoryIterator(resource_path('lang'));
        $it = new \CallbackFilterIterator($it, $exclude);

        foreach ($it as $file) {
            yield $file->getFilename();
        }
    }
}
