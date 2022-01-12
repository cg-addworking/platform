<?php

namespace Components\Enterprise\Document\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsNotSupportException extends Exception
{
    const MESSAGE = "User is not support";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
