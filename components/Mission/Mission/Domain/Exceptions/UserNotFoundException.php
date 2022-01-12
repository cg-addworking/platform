<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class UserNotFoundException extends Exception
{
    const MESSAGE = 'User not found';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
