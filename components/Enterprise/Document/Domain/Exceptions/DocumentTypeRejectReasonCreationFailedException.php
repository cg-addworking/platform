<?php

namespace Components\Enterprise\Document\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentTypeRejectReasonCreationFailedException extends Exception
{
    const MESSAGE = "Document type reject reason creation as failed.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
