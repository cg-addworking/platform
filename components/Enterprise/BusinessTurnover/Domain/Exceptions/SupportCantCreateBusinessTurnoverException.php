<?php

namespace Components\Enterprise\BusinessTurnover\Domain\Exceptions;

use Exception;
use Throwable;

class SupportCantCreateBusinessTurnoverException extends Exception
{
    const MESSAGE = "Support can't create a business turnover";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
