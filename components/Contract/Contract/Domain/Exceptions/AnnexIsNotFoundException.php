<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class AnnexIsNotFoundException extends Exception
{
    const MESSAGE = "Annex is not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
