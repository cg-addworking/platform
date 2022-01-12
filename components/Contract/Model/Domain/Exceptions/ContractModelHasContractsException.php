<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class ContractModelHasContractsException extends Exception
{
    const MESSAGE = "Contract model unpublished has failed because Contract model has contracts";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
