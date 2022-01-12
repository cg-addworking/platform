<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Exceptions;

use Exception;
use Throwable;

class InvoiceParameterCreationFailedException extends Exception
{
    const MESSAGE = "Could not create invoice parameter";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
