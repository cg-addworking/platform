<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

interface DocumentDataExtractorServiceInterface
{
    public function extractDataFrom(\SplFileInfo $file): ?DocumentDataInterface;
}
