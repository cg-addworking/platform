<?php

namespace Components\User\User\Domain\Exceptions;

class UnauthenticatedException extends \RuntimeException
{
    private const MESSAGE = "User is not authenticated";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
