<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceDoesntHaveItemsException extends Exception
{
    const MESSAGE = "Inbound invoice doesnt have items";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
