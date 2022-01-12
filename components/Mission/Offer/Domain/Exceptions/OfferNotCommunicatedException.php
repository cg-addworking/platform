<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class OfferNotCommunicatedException extends Exception
{
    const MESSAGE = "The offer is not communicated";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
