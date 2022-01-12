<?php

namespace Components\Enterprise\Enterprise\Domain\Exceptions;

use Exception;
use Throwable;

class VendorIsNotCompliantTodayException extends Exception
{
    const MESSAGE = "Vendor is not compliant today";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
