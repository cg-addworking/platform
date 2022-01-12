<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

use Exception;
use Throwable;

class DocumentTypeModelIsNotPublishedException extends Exception
{
    const MESSAGE = "Document Type model unpublished has failed because Document Type model is not published";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
