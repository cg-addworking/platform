<?php

namespace Components\Enterprise\ActivityReport\Domain\Exceptions;

use Exception;
use Throwable;

class ActivityReportMissionCreationFailedException extends Exception
{
    const MESSAGE = 'Activity Report Mission creation failed for the mission : ';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
