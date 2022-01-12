<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class OutboundInvoiceIsNotInPendingStatusException extends Exception
{
    const MESSAGE = "Outbound invoice is not in 'Pending' status";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
