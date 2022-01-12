<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentIsNotValidatedException extends Exception
{
    const MESSAGE = "Document is not validated";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
