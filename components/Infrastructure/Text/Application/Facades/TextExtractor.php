<?php

namespace Components\Infrastructure\Text\Application\Facades;

use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;
use Illuminate\Support\Facades\Facade;

class TextExtractor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TextExtractorServiceInterface::class;
    }
}
