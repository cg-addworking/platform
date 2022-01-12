<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class MissionAlreadyAssignedToAContractException extends Exception
{
    const MESSAGE = "Mission is already assigned to a different contract";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
