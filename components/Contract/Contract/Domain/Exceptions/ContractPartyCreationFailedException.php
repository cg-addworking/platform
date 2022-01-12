<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractPartyCreationFailedException extends \Exception
{
    const MESSAGE = "Contract party creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
