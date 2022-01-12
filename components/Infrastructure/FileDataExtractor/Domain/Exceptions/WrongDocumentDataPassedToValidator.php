<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Exceptions;

use Exception;
use Throwable;

class WrongDocumentDataPassedToValidator extends Exception
{
    const MESSAGE = "Wrong document Data passed to validator::specificValidation";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
