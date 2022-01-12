<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class EnterpriseIsNotContractOwnerException extends \Exception
{
    const MESSAGE = "Enterprise is not contract owner";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
