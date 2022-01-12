<?php

namespace Components\Infrastructure\Foundation\Application\Test;

use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Validation\ValidationException;

trait DebugsCsvLoaders
{
    protected function debug(CsvLoader $loader)
    {
        if ($loader->hasErrors() && $this->debug) {
            foreach ($loader->getErrors() as $item) {
                $e = $loader->getError($item);
                dump($item, $e instanceof ValidationException ? $e->errors() : $e->getMessage());
            }
        }
    }
}
