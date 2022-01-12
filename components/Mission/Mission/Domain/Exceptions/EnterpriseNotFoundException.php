<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseNotFoundException extends Exception
{
    const MESSAGE = 'Enterprise not found';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
