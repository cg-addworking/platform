<?php
namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class ReceivedPaymentCreationFailedException extends Exception
{
    const MESSAGE = 'Received payment creation failed';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
