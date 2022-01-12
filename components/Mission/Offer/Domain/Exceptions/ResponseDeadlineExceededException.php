<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class ResponseDeadlineExceededException extends Exception
{
    const MESSAGE = 'The deadline for responses has been reached';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
