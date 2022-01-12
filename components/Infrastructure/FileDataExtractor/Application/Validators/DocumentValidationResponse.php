<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;

class DocumentValidationResponse implements DocumentValidationResponseInterface
{
    protected $valid;
    protected $data;

    public function __construct(bool $valid, array $data = [])
    {
        $this->valid = $valid;
        $this->data = $data;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
