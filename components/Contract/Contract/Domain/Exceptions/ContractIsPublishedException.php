<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Exception;
use Throwable;

class ContractIsPublishedException extends Exception
{
    const MESSAGE = "Contract update has failed because it was published already";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
