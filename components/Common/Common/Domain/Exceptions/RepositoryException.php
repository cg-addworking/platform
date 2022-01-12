<?php

namespace Components\Common\Common\Domain\Exceptions;

class RepositoryException extends \RuntimeException
{
    private const MESSAGE = "Repository exception";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
