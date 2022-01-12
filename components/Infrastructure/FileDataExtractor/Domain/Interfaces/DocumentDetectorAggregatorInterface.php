<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;

interface DocumentDetectorAggregatorInterface
{
    public function push(DocumentDetectorInterface $detector): void;

    public function detect(\SplFileInfo $file): ?DocumentDetectorInterface;
}
