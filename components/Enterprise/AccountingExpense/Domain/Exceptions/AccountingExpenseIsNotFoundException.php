<?php

namespace Components\Enterprise\AccountingExpense\Domain\Exceptions;

use Exception;
use Throwable;

class AccountingExpenseIsNotFoundException extends Exception
{
    const MESSAGE = "Accounting expense is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
