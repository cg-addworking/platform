<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class OutboundInvoiceItemNotExistsException extends Exception
{
    const MESSAGE = "Outbound invoice item doesnt exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
