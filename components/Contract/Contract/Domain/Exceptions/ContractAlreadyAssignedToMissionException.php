<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class ContractAlreadyAssignedToMissionException extends Exception
{
    const MESSAGE = "Contract is already assigned to a different mission";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
