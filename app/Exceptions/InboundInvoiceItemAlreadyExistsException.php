<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceItemAlreadyExistsException extends Exception
{
    const MESSAGE = "This inbound invoice item has already been created.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
