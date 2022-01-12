<?php

namespace Components\Enterprise\AccountingExpense\Domain\Exceptions;

use Exception;
use Throwable;

class AccountingExpenseCreationFailedException extends Exception
{
    const MESSAGE = "accounting expense creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
