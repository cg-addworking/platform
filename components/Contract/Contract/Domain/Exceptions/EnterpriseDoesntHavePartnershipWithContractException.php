<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHavePartnershipWithContractException extends Exception
{
    const MESSAGE = "Enterprise doesn't have partnership wih the contract";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
