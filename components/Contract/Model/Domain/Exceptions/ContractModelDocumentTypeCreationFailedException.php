<?php
namespace Components\Contract\Model\Domain\Exceptions;

use Exception;
use Throwable;

class ContractModelDocumentTypeCreationFailedException extends Exception
{
    const MESSAGE = "Contract model document type creation failed.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
