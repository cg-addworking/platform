<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class DocumentTypeModelCreationFailedException extends \Exception
{
    const MESSAGE = "Document type model creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
