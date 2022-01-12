<?php

namespace Components\Enterprise\Enterprise\Domain\Exceptions;

use Exception;
use Throwable;

class VendorWasNotCompliantLastWeekException extends Exception
{
    const MESSAGE = "Vendor was not compliant last week";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
