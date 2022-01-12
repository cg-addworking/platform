<?php
namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class OutboundInvoiceNotExistsException extends Exception
{
    const MESSAGE = "Outbound invoice doesnt exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
