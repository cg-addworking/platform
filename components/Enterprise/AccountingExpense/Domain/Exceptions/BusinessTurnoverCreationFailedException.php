<?php

namespace Components\Enterprise\AccountingExpense\Domain\Exceptions;

use Exception;
use Throwable;

class BusinessTurnoverCreationFailedException extends Exception
{
    const MESSAGE = "business turnover creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
