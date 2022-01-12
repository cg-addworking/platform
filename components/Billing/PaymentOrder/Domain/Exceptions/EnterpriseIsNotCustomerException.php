<?php

namespace Components\Billing\PaymentOrder\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseIsNotCustomerException extends Exception
{
    const MEESAGE = "Enterprise type is not customer";

    public function __construct($message = self::MEESAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
