<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class OfferCantBeDeletedException extends Exception
{
    const MESSAGE = 'Offer Already communicated';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
