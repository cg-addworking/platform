<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class SearchFieldIsNotAllowedException extends Exception
{
    const MESSAGE = "User is not allowed to search by this field.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
