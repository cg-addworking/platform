<?php

namespace Components\Enterprise\WorkField\Domain\Exceptions;

use Exception;
use Throwable;

class ContributorIsNotMemberOfOwnerEnterpriseOrDescendantException extends Exception
{
    const MESSAGE = "Contributor is not member of owner enterprise or descendant";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
