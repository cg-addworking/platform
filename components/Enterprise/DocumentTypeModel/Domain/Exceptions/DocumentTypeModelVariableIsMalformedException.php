<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class DocumentTypeModelVariableIsMalformedException extends \Exception
{
    const MESSAGE = "Document type model variable is malformed";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
