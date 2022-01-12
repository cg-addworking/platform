<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractPartOrderIsLastOneException extends \Exception
{
    const MESSAGE = "Contract part is te last of the visible ones by order";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
