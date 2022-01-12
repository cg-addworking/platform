<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;

interface DocumentValidatorFactoryInterface
{
    public function makeFromDetector(DocumentDetectorInterface $detector): DocumentValidatorInterface;
}
