<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class UserHasNotPermissionToShowMissionException extends Exception
{
    const MESSAGE = "User has no permission to show this mission";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
