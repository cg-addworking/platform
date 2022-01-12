<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHaveAccessToContractModelException extends Exception
{
    const MESSAGE = "Enterprise does not have access to the contract model";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
