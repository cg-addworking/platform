<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHaveAccessToBillingException extends Exception
{
    const MESSAGE = "Enterprise doesnt have access to billing module";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
