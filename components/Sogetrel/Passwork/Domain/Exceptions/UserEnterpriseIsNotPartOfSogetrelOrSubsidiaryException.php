<?php

namespace Components\Sogetrel\Passwork\Domain\Exceptions;

use Exception;
use Throwable;

class UserEnterpriseIsNotPartOfSogetrelOrSubsidiaryException extends Exception
{
    const MESSAGE = "User enterprise is not part of sogetrel or subsidiary";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
