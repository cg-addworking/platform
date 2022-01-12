<?php

namespace Components\Enterprise\InvoiceParameter\Domain\Exceptions;

class CustomerBillingDeadlineCreationFailedException extends \Exception
{
    const MESSAGE = "Customer billing deadline creation failed";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
