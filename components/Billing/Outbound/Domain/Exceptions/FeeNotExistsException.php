<?php

namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class FeeNotExistsException extends Exception
{
    const MESSAGE = "Fee doesnt exist";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
