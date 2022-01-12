<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseIsNotAttachedException extends Exception
{
    const MESSAGE = "Enterprise is not attached to the work field";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
