<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class OutboundInvoiceIsAlreadyValidatedException extends Exception
{
    const MESSAGE = "Outbound invoice is already validated";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
