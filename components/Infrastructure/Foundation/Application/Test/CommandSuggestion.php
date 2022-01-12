<?php

namespace Components\Infrastructure\Foundation\Application\Test;

use Illuminate\Support\Arr;

class CommandSuggestion extends InteractiveSuggestion
{
    protected $command;

    public function __construct(string $command, ...$args)
    {
        $this->command = vsprintf($command, array_map('escapeshellarg', Arr::flatten($args)));
    }

    public function handle()
    {
        Printer::print("run the following command\n\n  <green>{$this->command}</green>\n\n");

        // are we running inside a terminal?
        if (! stream_isatty(STDOUT)) {
            return;
        }

        if (! $this->confirm("Do you want to run this command?")) {
            return;
        }

        passthru($this->command, $exit);

        Printer::print(($exit == 0 ? "<green>Success!</green>" : "<red>Execution failed!</red>") . "\n");
    }
}
