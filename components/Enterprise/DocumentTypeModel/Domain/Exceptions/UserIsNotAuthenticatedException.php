<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class UserIsNotAuthenticatedException extends \Exception
{
    const MESSAGE = "User is not authenticated";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
