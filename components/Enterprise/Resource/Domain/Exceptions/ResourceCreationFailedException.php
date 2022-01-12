<?php

namespace Components\Enterprise\Resource\Domain\Exceptions;

use Exception;
use Throwable;

class ResourceCreationFailedException extends Exception
{
    const MESSAGE = 'Resource creation failed';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
