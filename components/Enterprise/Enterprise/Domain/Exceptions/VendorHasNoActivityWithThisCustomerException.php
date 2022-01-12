<?php

namespace Components\Enterprise\Enterprise\Domain\Exceptions;

use Exception;
use Throwable;

class VendorHasNoActivityWithThisCustomerException extends Exception
{
    const MESSAGE = "Vendor has no activity with the customer";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
