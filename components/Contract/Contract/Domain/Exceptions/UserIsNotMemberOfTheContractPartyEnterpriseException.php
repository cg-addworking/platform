<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsNotMemberOfTheContractPartyEnterpriseException extends Exception
{
    const MESSAGE = "User is not member of the contract party enterprise";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
