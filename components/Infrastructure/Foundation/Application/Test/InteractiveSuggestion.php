<?php

namespace Components\Infrastructure\Foundation\Application\Test;

abstract class InteractiveSuggestion implements Suggestion
{
    public function confirm(string $message): bool
    {
        // is STDOUT a pipe?
        if (! stream_isatty(STDOUT)) {
            return false; // do nothing in that case!
        }

        do {
            $answer  = strtolower(trim(readline("{$message} [y/N]:"))) ?: 'no';

            if (! ($valid = in_array($answer, ['yes', 'ye', 'y', 'no', 'n']))) {
                Printer::print("<red>Unrecognized input: {$answer}</red>");
            }
        } while (! $valid);

        return in_array($answer, ['yes', 'ye', 'y']);
    }
}
