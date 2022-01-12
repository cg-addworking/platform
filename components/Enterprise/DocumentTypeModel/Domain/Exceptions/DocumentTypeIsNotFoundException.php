<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class DocumentTypeIsNotFoundException extends \Exception
{
    const MESSAGE = "Document type is not found";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
