<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class InboundInvoiceIsNotInPendingAssociationStatusException extends Exception
{
    const MESSAGE = "Inbound invoice is not in 'Pending association' status";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
