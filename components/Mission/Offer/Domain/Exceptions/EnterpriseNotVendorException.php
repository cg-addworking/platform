<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseNotVendorException extends Exception
{
    const MESSAGE = 'Enterprise is not vendor';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
