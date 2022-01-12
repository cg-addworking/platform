<?php

namespace Components\Enterprise\Document\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentTypeRejectReasonIsNotFoundException extends Exception
{
    const MESSAGE = "Reject reason is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
