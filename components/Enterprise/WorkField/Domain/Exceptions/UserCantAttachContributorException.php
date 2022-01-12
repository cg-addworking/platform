<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class UserCantAttachContributorException extends Exception
{
    const MESSAGE = "User can't attach a contributor to the workfield";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
