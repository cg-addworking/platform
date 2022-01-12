<?php

namespace Components\Mission\Mission\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseIsNotAssociatedToConstructionSectorException extends Exception
{
    const MESSAGE = 'Enterprise is not associated to construction sector';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
