<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Exceptions;

use Exception;
use Throwable;

class UserNotAuthentificatedException extends Exception
{
    const MESSAGE = "User is not authentificated";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
