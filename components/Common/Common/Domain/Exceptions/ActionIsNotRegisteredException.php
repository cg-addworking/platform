<?php

namespace Components\Common\Common\Domain\Exceptions;

class ActionIsNotRegisteredException extends \RuntimeException
{
    private const MESSAGE = "This action name is not recognized by the system. 
                            It needs do be added to the right Entity Interface";

    public function __construct(string $message = self::MESSAGE, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
