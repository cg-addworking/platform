<?php

namespace Components\Infrastructure\Translation\Application\Commands\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait FilesTrait
{
    protected $keyRegex = "/\W(__|@lang|trans_choice|trans)\((.*)(\)|,)/U";

    protected function getTranslationFiles(string $lang): \Generator
    {
        if (! is_dir($dir = resource_path("lang/{$lang}"))) {
            throw new \RuntimeException("no such file or directory '{$dir}'");
        }

        yield from $this->getFiles([$dir]);
    }

    protected function getIndex(array $langs, bool $sort = true): array
    {
        foreach ($langs as $lang) {
            foreach ($this->getTranslationFiles($lang) as $file) {
                $prefix = $file->getBasename('.php');
                foreach (Arr::dot(require $file->getPathname()) as $key => $value) {
                    // ignore '...' => [],
                    if (! is_string($value)) {
                        continue;
                    }

                    $key = "{$prefix}.{$key}";

                    if (! isset($index[$key])) {
                        $index[$key] = [];
                    }

                    $index[$key] += [$lang => $value];
                }
            }
        }

        if ($sort) {
            ksort($index);
        }

        return $index;
    }

    protected function getKeysFromFile(\SplFileInfo $file): array
    {
        static $cache = [];
        $cached = &$cache[$file->getPathname()];

        if (isset($cached)) {
            return $cached;
        }

        $contents = file_get_contents($file);

        $keys = preg_match_all($this->keyRegex, $contents, $matches);
        $keys = array_unique(array_map(fn($key) => trim($key, '\'"'), $matches[2] ?? []));

        return $cached = $keys;
    }

    protected function getKeysFromFiles(array $paths): array
    {
        $keys = [];

        foreach ($this->getFiles($paths) as $file) {
            $keys = array_merge($keys, $this->getKeysFromFile($file));
        }

        $keys = array_unique($keys);
        sort($keys);
        return $keys;
    }

    protected function getFiles(array $paths): \Generator
    {
        foreach ($paths as $path) {
            if (is_file($path)) {
                yield new \SplFileInfo($path);
                continue;
            }

            if (! is_dir($path)) {
                throw new \RuntimeException("{$path} is not a directory ");
            }

            $it = new \RecursiveDirectoryIterator($path);
            $it = new \RecursiveIteratorIterator($it);
            $it = new \RegexIterator($it, '/\.php$/', \RegexIterator::MATCH);

            yield from $it;
        }
    }

    protected function getExcludedPaths(): array
    {
        return property_exists($this, 'exclude') ? Arr::wrap($this->exclude) : [];
    }
}
