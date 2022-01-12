<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\Exceptions;

class UserIsNotSupportException extends \Exception
{
    const MESSAGE = "User is not support";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
