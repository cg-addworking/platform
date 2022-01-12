<?php

namespace Components\Infrastructure\Foundation\Application;

use Illuminate\Support\Facades\Log;

trait Deprecated
{
    protected static function deprecated(string $method, string $replacement): void
    {
        //Log::info("Usage of {$method} is deprecated. Use {$replacement} instead.");
    }
}
