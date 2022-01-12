<?php

namespace Components\Enterprise\AccountingExpense\Domain\Exceptions;

use Exception;
use Throwable;

class AccountingExpenseHasMissionTrackingLinesException extends Exception
{
    const MESSAGE = "Accounting expense has mission tracking lines.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
