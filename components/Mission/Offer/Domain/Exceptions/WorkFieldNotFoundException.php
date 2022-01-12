<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class WorkFieldNotFoundException extends Exception
{
    const MESSAGE = 'Work Field not found';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
