<?php

namespace Components\Contract\Contract\Domain\Exceptions;

use Throwable;

class ContractIsNotGenerateException extends \Exception
{
    const MESSAGE = "Contract is not generate";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
