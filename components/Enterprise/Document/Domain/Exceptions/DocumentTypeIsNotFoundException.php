<?php

namespace Components\Enterprise\Document\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentTypeIsNotFoundException extends Exception
{
    const MESSAGE = "Document type is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
