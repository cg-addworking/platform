<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

interface DocumentValidationResponseInterface
{
    public function isValid(): bool;

    public function toArray(): array;
}
