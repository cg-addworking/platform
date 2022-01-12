<?php

namespace Components\Enterprise\Resource\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHaveAccessToResourceException extends Exception
{
    const MESSAGE = "Enterprise doesnt have access to resource module";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
