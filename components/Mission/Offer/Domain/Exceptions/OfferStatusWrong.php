<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class OfferStatusWrong extends Exception
{
    const MESSAGE = 'Offer status wrong';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
