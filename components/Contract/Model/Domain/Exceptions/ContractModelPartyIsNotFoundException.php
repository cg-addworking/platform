<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class ContractModelPartyIsNotFoundException extends Exception
{
    const MESSAGE = "Contract model party is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
