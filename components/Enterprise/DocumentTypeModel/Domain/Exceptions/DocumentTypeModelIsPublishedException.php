<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentTypeModelIsPublishedException extends Exception
{
    const MESSAGE = "Document type model is already published";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
