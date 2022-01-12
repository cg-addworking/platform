<?php

namespace Components\Common\Common\Domain\Exceptions;

use Components\Common\Common\Domain\Exceptions\RepositoryException;

class UnableToSaveException extends RepositoryException
{
    private const MESSAGE = "Unable to save";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
