<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class MinimumPartiesNotReachedException extends Exception
{
    const MESSAGE = "contract model needs to have at least 2 parties";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
