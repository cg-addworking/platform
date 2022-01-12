<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class AmendmentCantBeCreatedFromAmendment extends Exception
{
    const MESSAGE = 'Amendment can\'t be created from another amendment';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
