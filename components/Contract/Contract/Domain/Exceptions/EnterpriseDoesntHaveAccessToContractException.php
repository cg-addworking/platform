<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHaveAccessToContractException extends Exception
{
    const MESSAGE = "Enterprise does not have access to the contract";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
