<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class ContributorIsNotAttachedException extends Exception
{
    const MESSAGE = "Contributor is not attached to the work field";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
