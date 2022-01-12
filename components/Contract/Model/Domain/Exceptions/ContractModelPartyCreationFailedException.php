<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Throwable;

class ContractModelPartyCreationFailedException extends \Exception
{
    const MESSAGE = "Contract model party creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
