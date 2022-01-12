<?php

namespace Components\Contract\Contract\Domain\Exceptions;

class CaptureInvoiceCreationFailedException extends \Exception
{
    const MESSAGE = 'Capture invoice creation failed';

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
