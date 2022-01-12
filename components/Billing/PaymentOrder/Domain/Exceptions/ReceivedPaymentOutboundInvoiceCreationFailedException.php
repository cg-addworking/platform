<?php
namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class ReceivedPaymentOutboundInvoiceCreationFailedException extends Exception
{
    const MESSAGE = 'Payment outbound creation failed';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
