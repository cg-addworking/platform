<?php

namespace Components\Enterprise\ActivityReport\Domain\Exceptions;

use Exception;
use Throwable;

class EnterpriseDoesntHaveAccessToActivityReportException extends Exception
{
    const MESSAGE = "Enterprise doesnt have access to ActivityReport module";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
