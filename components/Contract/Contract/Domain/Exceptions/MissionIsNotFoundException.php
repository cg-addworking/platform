<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class MissionIsNotFoundException extends Exception
{
    const MESSAGE = "Enterprise is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
