<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Detectors;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;
use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;

abstract class DocumentDetector implements DocumentDetectorInterface
{
    protected $textExtractor;

    public function __construct(TextExtractorServiceInterface $textExtractor)
    {
        $this->textExtractor = $textExtractor;
    }

    protected function getTextExtractor(): TextExtractorServiceInterface
    {
        return $this->textExtractor;
    }
}
