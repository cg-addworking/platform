<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class UserHasNotPermissionToDeleteAWorkFieldException extends Exception
{
    const MESSAGE = "User has no permission to delete this work field";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
