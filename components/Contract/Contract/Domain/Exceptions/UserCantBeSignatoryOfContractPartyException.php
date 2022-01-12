<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserCantBeSignatoryOfContractPartyException extends Exception
{
    const MESSAGE = "User can not be signatory of the contract party";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
