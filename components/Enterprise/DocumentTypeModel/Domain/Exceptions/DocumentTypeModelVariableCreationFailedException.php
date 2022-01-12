<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class DocumentTypeModelVariableCreationFailedException extends \Exception
{
    const MESSAGE = "Document type model variable creation failed";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
