<?php

namespace Components\Common\Common\Domain\Exceptions;

class EntityIsMissingActionRelationshipException extends \RuntimeException
{
    private const MESSAGE = "Your entity needs to have an actions() relationship.";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
