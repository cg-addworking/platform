<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class CannotEditMissionInThisStatusException extends Exception
{
    const MESSAGE = 'Cannot Edit Mission In This Status';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
