<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;

interface DocumentDataExtractorInterface
{
    public function extract(\SplFileInfo $file): DocumentDataInterface;
}
