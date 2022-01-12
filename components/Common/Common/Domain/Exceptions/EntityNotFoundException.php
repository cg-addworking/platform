<?php

namespace Components\Common\Common\Domain\Exceptions;

class EntityNotFoundException extends \RuntimeException
{
    private const MESSAGE = "Entity not found";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
