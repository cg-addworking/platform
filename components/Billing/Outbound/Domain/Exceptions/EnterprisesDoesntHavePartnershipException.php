<?php
namespace Components\Billing\Outbound\Domain\Exceptions;

use Exception;
use Throwable;

class EnterprisesDoesntHavePartnershipException extends Exception
{
    const MESSAGE = "Customer doesn't have partnership with this vendor";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
