<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class CustomerNotFoundException extends Exception
{
    const MESSAGE = 'Customer not found';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
