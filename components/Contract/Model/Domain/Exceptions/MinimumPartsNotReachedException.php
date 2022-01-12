<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class MinimumPartsNotReachedException extends Exception
{
    const MESSAGE = "contract model needs to have at least 1 part";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
