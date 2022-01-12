<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors\Data;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\DocumentDataExtractor;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;

class DocumentData implements DocumentDataInterface
{
    protected $detector;
    protected $extractor;
    protected $data;

    public function __construct(DocumentDataExtractor $extractor, array $data = [])
    {
        $this->extractor = $extractor;
        $this->data = $data;
    }

    public function getExtractor(): DocumentDataExtractorInterface
    {
        return $this->extractor;
    }

    public function setDetector(DocumentDetectorInterface $detector): void
    {
        $this->detector = $detector;
    }

    public function getDetector(): ?DocumentDetectorInterface
    {
        return $this->detector;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
