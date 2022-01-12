<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class OfferCreationFailedException extends Exception
{
    const MESSAGE = 'Offer creation failed';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
