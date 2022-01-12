<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class InvoiceParametersNotInformedException extends Exception
{
    const MESSAGE = "Invoice parameters doesn't informed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
