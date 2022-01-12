<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;

interface DocumentValidatorServiceInterface
{
    public function check(\SplFileInfo $file): DocumentValidationResponseInterface;
}
