<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Exceptions;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorFactoryInterface;

class UnableToMakeValidator extends \RuntimeException
{
    protected $factory;

    public function __construct(
        DocumentValidatorFactoryInterface $factory,
        string $message,
        \Throwable $previous = null
    ) {
        $this->factory = $factory;

        parent::__construct($message, 0, $previous);
    }

    public function getFactory(): DocumentValidatorFactoryInterface
    {
        return $this->factory;
    }
}
