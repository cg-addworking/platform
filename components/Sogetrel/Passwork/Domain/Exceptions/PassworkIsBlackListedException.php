<?php

namespace Components\Sogetrel\Passwork\Domain\Exceptions;

use Exception;
use Throwable;

class PassworkIsBlackListedException extends Exception
{
    const MESSAGE = "Passwork is blacklisted";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
