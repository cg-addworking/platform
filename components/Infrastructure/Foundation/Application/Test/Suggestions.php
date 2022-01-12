<?php

namespace Components\Infrastructure\Foundation\Application\Test;

use BadMethodCallException;
use Components\Infrastructure\Foundation\Application\Test\Suggestion;
use PHPUnit\Framework\ExpectationFailedException;
use InvalidArgumentException;

trait Suggestions
{
    public function __call($method, $args)
    {
        if (! preg_match('/^(assert\w+)OrSuggest$/', $method, $matches)) {
            throw new BadMethodCallException("no such method '{$method}'");
        }

        $method     = $matches[1];
        $suggestion = array_pop($args);
        $message    = end($args);

        if (is_string($suggestion)) {
            $suggestion = $this->suggest($suggestion);
        }

        if (! $suggestion instanceof Suggestion) {
            throw new InvalidArgumentException("not a suggestion");
        }

        try {
            $this->$method(...$args);
        } catch (ExpectationFailedException $failure) {
            Printer::print("<red>{$failure->getMessage()}</red>\n\n");
            Printer::print("<yellow>Suggestion:</yellow> ");
            $suggestion->handle();
        } finally {
            if (isset($failure)) {
                throw $failure;
            }
        }
    }

    public function suggest(string $message, ...$args): Suggestion
    {
        return new MessageSuggestion($message, $args);
    }

    public function suggestCommand(string $command, ...$args): Suggestion
    {
        return new CommandSuggestion($command, $args);
    }
}
