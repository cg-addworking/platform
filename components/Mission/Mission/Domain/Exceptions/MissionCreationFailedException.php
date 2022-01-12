<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class MissionCreationFailedException extends Exception
{
    const MESSAGE = 'Mission creation failed';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
