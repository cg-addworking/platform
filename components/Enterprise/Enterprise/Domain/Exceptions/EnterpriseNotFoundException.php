<?php

namespace Components\Enterprise\Enterprise\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseNotFoundException extends Exception
{
    const MESSAGE = "enterprise not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
