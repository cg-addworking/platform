<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class IbanNotFoundException extends Exception
{
    const MESSAGE = "Iban not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
