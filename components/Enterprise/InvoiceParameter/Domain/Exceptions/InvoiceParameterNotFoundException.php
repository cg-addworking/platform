<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Exceptions;

use Exception;
use Throwable;

class InvoiceParameterNotFoundException extends Exception
{
    const MESSAGE = "invoice parameter not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
