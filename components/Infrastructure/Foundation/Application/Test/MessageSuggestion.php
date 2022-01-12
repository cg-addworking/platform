<?php

namespace Components\Infrastructure\Foundation\Application\Test;

class MessageSuggestion implements Suggestion
{
    protected $message;

    public function __construct(string $message, ...$args)
    {
        $this->message = Printer::colorize($message, $args);
    }

    public function handle()
    {
        Printer::print($this->message . "\n\n");
    }
}
