<?php

namespace Components\Enterprise\ActivityReport\Domain\Exceptions;

use Exception;
use Throwable;

class ActivityReportCreationFailedException extends Exception
{
    const MESSAGE = 'Activity Report creation failed for the vendor : ';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
