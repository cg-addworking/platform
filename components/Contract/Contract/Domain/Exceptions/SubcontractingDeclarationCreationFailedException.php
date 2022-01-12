<?php

namespace Components\Contract\Contract\Domain\Exceptions;

class SubcontractingDeclarationCreationFailedException extends \Exception
{
    const MESSAGE = "Subcontracting declaration creation as failed.";

    public function __construct($message = self::MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
