<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;

interface DocumentSplitterServiceInterface
{
    public function splitPdf($filename): array;
}
