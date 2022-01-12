<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class ContractVariableDoesNotExistException extends Exception
{
    const MESSAGE = "Contract variable does not exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
