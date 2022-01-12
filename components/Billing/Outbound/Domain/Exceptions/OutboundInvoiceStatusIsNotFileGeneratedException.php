<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class OutboundInvoiceStatusIsNotFileGeneratedException extends Exception
{
    const MESSAGE = "outbound invoice status is not file generated";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
