<?php

namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceIsAlreadyPaidException extends Exception
{
    const MESSAGE = "Inbound invoice is already paid";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
