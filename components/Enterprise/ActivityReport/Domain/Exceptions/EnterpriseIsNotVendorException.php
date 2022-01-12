<?php

namespace Components\Enterprise\ActivityReport\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseIsNotVendorException extends Exception
{
    const MEESAGE = "Enterprise type is not vendor";

    public function __construct($message = self::MEESAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
