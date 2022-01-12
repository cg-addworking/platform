<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractCreationFailedException extends \Exception
{
    const MESSAGE = "Contract creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
