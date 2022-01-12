<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsNotAllowedToArchiveContractException extends Exception
{
    const MESSAGE = "User is not allowed to archive this contract.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
