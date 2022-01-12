<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceIsAlreadyAssociatedToThisOutboundInvoiceException extends Exception
{
    const MESSAGE = "Inbound invoiceis already associated to this outbound invoice";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
