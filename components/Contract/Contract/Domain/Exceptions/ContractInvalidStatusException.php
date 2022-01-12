<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class ContractInvalidStatusException extends Exception
{
    const MESSAGE = "Passed contract status is invalid.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
