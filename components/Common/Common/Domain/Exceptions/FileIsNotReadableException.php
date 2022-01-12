<?php

namespace Components\Common\Common\Domain\Exceptions;

class FileIsNotReadableException extends \RuntimeException
{
    private const MESSAGE = "This file cannot be read. Can't find CSV separator.";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
