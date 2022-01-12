<?php

namespace Components\Contract\Model\Domain\Exceptions;

use Throwable;

class MissionCreationFailedException extends \Exception
{
    const MESSAGE = "Mission creation has failed";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
