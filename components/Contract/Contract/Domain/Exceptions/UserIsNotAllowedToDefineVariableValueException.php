<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsNotAllowedToDefineVariableValueException extends Exception
{
    const MESSAGE = "User is not allowed to define this contract variable's value.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
