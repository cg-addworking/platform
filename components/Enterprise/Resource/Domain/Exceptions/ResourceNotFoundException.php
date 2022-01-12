<?php
namespace Components\Enterprise\Resource\Domain\Exceptions;

use Exception;
use Throwable;

class ResourceNotFoundException extends Exception
{
    const MESSAGE = "Resource not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
