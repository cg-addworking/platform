<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class UserHasNotPermissionToSendOfferException extends Exception
{
    const MESSAGE = "User has no permission to send this offer";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
