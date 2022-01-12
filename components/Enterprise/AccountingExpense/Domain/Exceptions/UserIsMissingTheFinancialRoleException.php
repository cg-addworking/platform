<?php

namespace Components\Enterprise\AccountingExpense\Domain\Exceptions;

use Exception;
use Throwable;

class UserIsMissingTheFinancialRoleException extends Exception
{
    const MESSAGE = "User is missing the financial role";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
