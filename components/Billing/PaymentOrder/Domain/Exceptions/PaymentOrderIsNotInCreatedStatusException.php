<?php
namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class PaymentOrderIsNotInCreatedStatusException extends Exception
{
    const MESSAGE = "Payment order is not in 'Created' status";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
