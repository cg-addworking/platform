<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseIsNotRequestedToDeclareBusinessTurnoverException extends Exception
{
    const MESSAGE = "business turnover not required for this enterprise";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
