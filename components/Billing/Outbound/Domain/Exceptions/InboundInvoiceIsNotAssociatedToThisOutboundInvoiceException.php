<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceIsNotAssociatedToThisOutboundInvoiceException extends Exception
{
    const MESSAGE = "Inbound invoice is not associated to this outbound invoice";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
