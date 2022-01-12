<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class FileNotExistsException extends Exception
{
    const MESSAGE = "File not exists";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
