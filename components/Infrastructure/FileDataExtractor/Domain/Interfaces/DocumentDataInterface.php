<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;

interface DocumentDataInterface
{
    public function getExtractor(): DocumentDataExtractorInterface;

    public function setDetector(DocumentDetectorInterface $detector): void;

    public function getDetector(): ?DocumentDetectorInterface;

    public function toArray(): array;
}
