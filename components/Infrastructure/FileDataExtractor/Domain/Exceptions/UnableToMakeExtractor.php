<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Exceptions;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorFactoryInterface;

class UnableToMakeExtractor extends \RuntimeException
{
    protected $factory;

    public function __construct(
        DocumentDataExtractorFactoryInterface $factory,
        string $message,
        \Throwable $previous = null
    ) {
        $this->factory = $factory;

        parent::__construct($message, 0, $previous);
    }

    public function getFactory(): DocumentDataExtractorFactoryInterface
    {
        return $this->factory;
    }
}
