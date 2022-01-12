<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

interface DocumentDataExtractorFactoryInterface
{
    public function makeFromDetector(DocumentDetectorInterface $detector): DocumentDataExtractorInterface;
}
