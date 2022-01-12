<?php
namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class PaymentOrderNotFoundException extends Exception
{
    const MESSAGE = "Payment order not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
