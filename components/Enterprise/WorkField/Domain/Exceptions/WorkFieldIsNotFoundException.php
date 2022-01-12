<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class WorkFieldIsNotFoundException extends Exception
{
    const MESSAGE = "Work field is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
