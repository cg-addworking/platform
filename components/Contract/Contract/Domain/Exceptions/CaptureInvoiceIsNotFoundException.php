<?php

namespace Components\Contract\Contract\Domain\Exceptions;

class CaptureInvoiceIsNotFoundException extends \Exception
{
    const MESSAGE = 'Capture invoice is not found';

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
