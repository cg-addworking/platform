<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsNotSupportOrMemberOfTheAnnexEnterpriseException extends Exception
{
    const MESSAGE = "User is not support or member of the annex enterprise";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
