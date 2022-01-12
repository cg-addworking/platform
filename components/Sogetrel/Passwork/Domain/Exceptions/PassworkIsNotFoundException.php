<?php

namespace Components\Sogetrel\Passwork\Domain\Exceptions;

use Exception;
use Throwable;

class PassworkIsNotFoundException extends Exception
{
    const MESSAGE = "Passwork is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
