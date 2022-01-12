<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class OfferAlreadyClosedException extends Exception
{
    const MESSAGE = 'Offer Already Closed';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
