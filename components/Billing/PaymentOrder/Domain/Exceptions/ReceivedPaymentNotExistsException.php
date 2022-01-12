<?php

namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class ReceivedPaymentNotExistsException extends Exception
{
    const MESSAGE = "Received payment doesn't exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
