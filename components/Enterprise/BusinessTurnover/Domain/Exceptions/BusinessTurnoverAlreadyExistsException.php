<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Exceptions;

use Exception;
use Throwable;

class BusinessTurnoverAlreadyExistsException extends Exception
{
    const MESSAGE = "business turnover for last year exists already";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
