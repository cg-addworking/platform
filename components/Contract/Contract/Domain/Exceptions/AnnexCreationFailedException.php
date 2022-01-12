<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class AnnexCreationFailedException extends Exception
{
    const MESSAGE = "Annex creation as failed.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
