<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsMissingTheWorkFieldCreationRoleException extends Exception
{
    const MESSAGE = "User is missing the workfield creation role";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
