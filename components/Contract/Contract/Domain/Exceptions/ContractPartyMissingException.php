<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractPartyMissingException extends \Exception
{
    const MESSAGE = "At least, one contract party is missing";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
