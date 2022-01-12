<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Traits\FilesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;

class Check extends Command
{
    use FilesTrait;

    protected $signature = 'translation:check {path?*} {--lang=fr}';

    protected $description = 'Checks translations';

    protected $translator;

    protected $errors = [];

    protected $warnings = [];

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;

        parent::__construct();
    }

    public function handle()
    {
        $this->translator->setLocale($this->option('lang'));

        $paths = $this->argument('path') ?: Config::get('view.paths');

        foreach ($this->getFiles($paths) as $file) {
            $this->checkFile($file);
        }

        $this->display();

        return count($this->errors);
    }

    protected function checkFile(\SplFileInfo $file)
    {
        foreach (file($file) as $line => $contents) {
            if (! preg_match_all($this->keyRegex, $contents, $matches)) {
                continue;
            }

            foreach ($matches[2] as $key) {
                $key = trim($key, '\'"');
                $translation = $this->translator->get($key);

                if (preg_match('/\$\w+/', $key)) {
                    $this->warnings[] = [$file, $line + 1, $key, "key contains a variable"];
                    continue;
                }

                if ($translation === "") {
                    $this->errors[] = [$file, $line + 1, $key, "translation message empty"];
                    continue;
                }

                if ($translation === $key) {
                    $this->errors[] = [$file, $line + 1, $key, "key not found"];
                    continue;
                }
            }
        }
    }

    protected function display()
    {
        if (! empty($this->warnings)) {
            $files = count(array_unique(array_map(fn($i) => $i[0], $this->warnings)));

            $this->output->writeln(
                sprintf(
                    "\n <bg=yellow;fg=black> Found %d warnings in %d files </>\n",
                    count($this->warnings),
                    $files
                )
            );

            $this->table(
                ['File:line', 'Key', 'Message'],
                array_map(fn($w) => [self::relative($w[0]).':'.$w[1], $w[2], $w[3]], $this->warnings)
            );
        }

        if (! empty($this->errors)) {
            $files = count(array_unique(array_map(fn($i) => $i[0], $this->errors)));

            $this->output->writeln(
                sprintf(
                    "\n <bg=red;fg=white> Found %d errors in %d files </>\n",
                    count($this->errors),
                    $files
                )
            );

            $this->table(
                ['File:line', 'Key', 'Message'],
                array_map(fn($e) => [self::relative($e[0]).':'.$e[1], $e[2], $e[3]], $this->errors)
            );
        }
    }

    protected static function relative(string $path): string
    {
        return Str::after(file_exists($path) ? realpath($path) : $path, getcwd() . "/");
    }
}
