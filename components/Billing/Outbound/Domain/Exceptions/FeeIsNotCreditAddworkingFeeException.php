<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class FeeIsNotCreditAddworkingFeeException extends Exception
{
    const MESSAGE = "Fee is not credit Addworking fee";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
