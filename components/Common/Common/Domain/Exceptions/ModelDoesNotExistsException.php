<?php

namespace Components\Common\Common\Domain\Exceptions;

class ModelDoesNotExistsException extends \LogicException
{
    private const MESSAGE = "Model does not exists";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
