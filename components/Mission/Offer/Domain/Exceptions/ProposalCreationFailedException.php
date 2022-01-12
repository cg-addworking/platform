<?php

namespace Components\Mission\Offer\Domain\Exceptions;

use Exception;
use Throwable;

class ProposalCreationFailedException extends Exception
{
    const MESSAGE = 'Proposal creation failed';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
