<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class ContractModelIsPublishedException extends Exception
{
    const MESSAGE = "Contract model update has failed because it has been published";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
