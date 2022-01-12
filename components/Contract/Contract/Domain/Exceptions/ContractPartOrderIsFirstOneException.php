<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractPartOrderIsFirstOneException extends \Exception
{
    const MESSAGE = "Contract part is te first one by order";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
