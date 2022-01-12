<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class ContractModelCreationFailedException extends Exception
{
    const MESSAGE = "Contract model creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
