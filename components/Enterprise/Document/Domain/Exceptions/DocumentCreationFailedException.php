<?php

namespace Components\Enterprise\Document\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentCreationFailedException extends Exception
{
    const MESSAGE = "Document creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
