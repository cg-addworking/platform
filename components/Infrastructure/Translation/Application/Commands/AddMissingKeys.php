<?php

namespace Components\Infrastructure\Translation\Application\Commands;

use Components\Infrastructure\Translation\Application\Commands\Check;
use Components\Infrastructure\Translation\Application\Commands\Traits\SerializeTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class AddMissingKeys extends Check
{
    use SerializeTrait;

    protected $signature = 'translation:add-missing-keys '.
        '{--lang=fr : Language} '.
        '{file?* : A file or directory to scan}';

    protected $description = 'Scans files for missing translation keys';

    public function handle()
    {
        $paths = $this->argument('file') ?: Config::get('view.paths');

        foreach ($this->getFiles($paths) as $file) {
            $this->checkFile($file);
        }

        return $this->apply($this->getPatch());
    }

    protected function apply(array $patch): int
    {
        if (empty($patch)) {
            $this->info("Congratulations! You application is fully translated.");
            return 0;
        }

        $this->table(['Key', 'Message'], $patch);

        if (! $this->confirm("Do you confirm those changes?")) {
            return 0;
        }

        foreach ($this->getReplacements($patch) as $filename => $values) {
            if (false == $path = $this->getLangFile($filename)) {
                continue;
            }

            $this->applyReplacements($path, $values);
        }

        return 0;
    }

    protected function getPatch(): array
    {
        $patch = [];

        foreach ($this->errors as $num => list($file, $line, $key, $message)) {
            if ($message != "key not found") {
                continue;
            }

            $this->showContext($num + 1, count($this->errors), $file, $line, $key);

            do {
                $value = $this->ask("What is the value? (type i to ignore)");
            } while (strlen($value = trim($value)) == 0);

            if ($value == 'i') {
                continue;
            }

            $patch[] = [$key, $value];
        }

        return $patch;
    }

    protected function getReplacements(array $patch): array
    {
        $replacements = [];

        foreach ($patch as list($key, $value)) {
            list($filename, $key) = explode('.', $key, 2);
            $replacements[$filename][$key] = $value;
        }

        return $replacements;
    }

    protected function applyReplacements(string $path, array $values): void
    {
        $messages = require $path;

        foreach ($values as $key => $value) {
            Arr::set($messages, $key, $value);
        }

        if (! file_put_contents($path, $this->serialize($messages))) {
            throw new \RuntimeException("unable to write '{$path}'");
        }
    }

    protected function showContext(int $num, int $total, string $file, int $line, string $key)
    {
        $this->getOutput()->writeln(sprintf(
            "<fg=yellow>[%d/%d]</> %s:%s\n",
            $num,
            $total,
            self::relative($file),
            $line
        ));

        $line_start = max(0, $line - 3);
        $lines = array_slice(file($file), $line_start, 5);
        $pre = strlen((string) ($line_start + 5));

        foreach ($lines as $i => $line_str) {
            $this->getOutput()->write(sprintf(
                "%{$pre}d: %s",
                $line_start + $i,
                self::colorizeKey($key, $line_str)
            ));
        }
    }

    protected function getLangFile(string $filename)
    {
        if (file_exists($path = resource_path("lang/{$this->option('lang')}/{$filename}.php"))) {
            return $path;
        }

        if (! $this->confirm("{$path} doesn't exists, do you want to create it?")) {
            return false;
        }

        if (! file_put_contents($path, "<?php\n\nreturn [];\n")) {
            throw new \RuntimeException("unable to write '{$path}'");
        }

        $this->line("{$path} created");
        return $path;
    }

    protected static function relative(string $path): string
    {
        return Str::after(file_exists($path) ? realpath($path) : $path, getcwd() . "/");
    }

    protected static function colorizeKey(string $key, string $line): string
    {
        $regex = preg_quote($key);

        return preg_replace("/({$regex})/", '<bg=yellow;fg=black>$1</>', $line);
    }
}
