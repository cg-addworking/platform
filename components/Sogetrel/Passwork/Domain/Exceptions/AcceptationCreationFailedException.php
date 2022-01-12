<?php

namespace Components\Sogetrel\Passwork\Domain\Exceptions;

use Exception;
use Throwable;

class AcceptationCreationFailedException extends Exception
{
    const MESSAGE = "Acceptation creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
