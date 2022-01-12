<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseNotExistsException extends Exception
{
    const MESSAGE = "Enterprise doesnt exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
