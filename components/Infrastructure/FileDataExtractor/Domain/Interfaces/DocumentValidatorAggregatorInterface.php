<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;

interface DocumentValidatorAggregatorInterface
{
    public function push(DocumentValidatorInterface $validator): void;

    public function detect(\SplFileInfo $file): ?DocumentValidatorInterface;
}
