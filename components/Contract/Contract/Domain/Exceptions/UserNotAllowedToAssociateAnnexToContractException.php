<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserNotAllowedToAssociateAnnexToContractException extends Exception
{
    const MESSAGE = "User is not allowed to associate annex to this contract";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
