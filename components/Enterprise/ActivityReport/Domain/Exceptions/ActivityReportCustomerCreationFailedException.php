<?php

namespace Components\Enterprise\ActivityReport\Domain\Exceptions;

use Exception;
use Throwable;

class ActivityReportCustomerCreationFailedException extends Exception
{
    const MESSAGE = 'Activity Report Customer creation failed for the customer : ';

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = self::MESSAGE . $message;

        parent::__construct($message, $code, $previous);
    }
}
