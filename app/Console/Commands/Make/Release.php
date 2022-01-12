<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use RuntimeException;

class Release extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:release {--major} {--minor} {--build} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates and pushes a release';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $oldTag = $this->getTags()->last();
        $newTag = $this->increaseTagNum($oldTag);

        $this->output->writeln("New tag number: <fg=green>{$newTag}</fg=green> (previous was {$oldTag})");
        $answer = $this->confirm("Are you sure you want to use tag {$newTag}?");

        if (!$answer) {
            $newTag = $this->normalizeTag($this->ask("How would you name the tag?"));
        }

        // update local develop & master
        $this->executeCommands([
            "git checkout develop",
            "git pull",
            "git checkout master",
            "git pull",
        ]);

        // check if develop is ahead of master
        list($behind, $ahead) = $this->getDiff('master', 'develop');

        if ($behind > 0) {
            $this->info("The branch 'develop' is behind 'master' of {$behind} commit(s), consider merging");
            return;
        }

        if ($ahead <= 0) {
            $this->info("There is no commit to add to this relase. Aborting.");
            return;
        }

        $this->executeCommands([
            "git checkout develop",
            "git checkout -b release/{$newTag}",
            "git checkout master",
            "git merge release/{$newTag}",
            "git log --graph --decorate --oneline {$oldTag}..release/{$newTag}",
        ]);

        if (!$this->confirm("Are you sure you want to push this master?")) {
            return;
        }

        $commands = [
            "git tag {$newTag}",
            "git push origin master {$newTag}",
            "git branch -D release/{$newTag}",
            "git checkout develop",
        ];

        foreach ($commands as $step => $command) {
            if (!$this->executeCommand($command)) {
                $this->error("Unable to execute: {$command}");
                return;
            }
        }
    }

    /**
     * Get the tag sorted by ascending version number
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getTags(): Collection
    {
        exec('git tag', $lines, $result);

        if ($result != 0) {
            throw new RuntimeException("Unable to fetch tags");
        }

        return collect($lines)
            ->filter(function ($tag) {
                return preg_match('/v\d+\.\d+\.\d+/', $tag);
            })
            ->sortBy(function ($tag) {
                $this->normalizeTag($tag, $major, $minor, $build);
                return $major * 10000 + $minor * 100 + $build;
            });
    }

    /**
     * Get the number of commits that are respectively behind and ahead
     * of $right starting from $left commits.
     *
     * @param  string $left
     * @param  string $right
     * @return array<int>
     */
    protected function getDiff(string $left, string $right): array
    {
        $line = exec("git rev-list --left-right --count {$left}...{$right}", $lines, $result);

        if ($result != 0) {
            throw new RuntimeException("Unable to fetch rev-list");
        }

        if (!preg_match('/(\d+)\s+(\d+)/', $line, $matches)) {
            throw new RuntimeException("Invalid rev-list: $line");
        }

        list(, $behind, $ahead) = $matches;
        return [$behind, $ahead];
    }

    /**
     * Normalizes a tag
     *
     * @param  string $tag
     * @param  int &$major
     * @param  int &$minor
     * @param  int &$build
     * @return string
     */
    protected function normalizeTag($tag, &$major = null, &$minor = null, &$build = null)
    {
        if (!preg_match('/v(\d+)\.(\d+)\.(\d+)$/', $tag, $matches)) {
            throw new RuntimeException("Invalid tag: {$tag}");
        }

        list(, $major, $minor, $build) = $matches;
        return "v{$major}.{$minor}.{$build}";
    }

    /**
    * Increase Tag Number.
    *
    * @param string $tag
    * @return string
    */
    protected function increaseTagNum($tag)
    {
        $this->normalizeTag($tag, $major, $minor, $build);

        switch (true) {
            case $this->option('minor'):
                $build  = 0;
                $minor += 1;
                break;

            case $this->option('major'):
                $build  = 0;
                $minor  = 0;
                $major += 1;
                break;

            case $this->option('build'):
            default:
                $build += 1;
                break;
        }

        return $this->normalizeTag("v{$major}.{$minor}.{$build}");
    }

    /**
    * Execute Git option command.
    *
    * @param string $cmd
    * @return boolean
    */
    protected function executeCommand(string $cmd): bool
    {
        if ($this->option('dry-run')) {
            $this->line($cmd);
            return true;
        }

        exec($cmd, $output, $return);

        if (!$this->option('quiet')) {
            $this->info("\n$ {$cmd}");
            $this->output->writeln($output);
        }

        return $return == 0;
    }

    /**
     * Execute commands in order and return true if all of them passed, false
     * otherwise.
     *
     * @param  array  $commands
     */
    protected function executeCommands(array $commands)
    {
        foreach ($commands as $step => $command) {
            if (!$this->executeCommand($command)) {
                throw new RuntimeException("Unable to execute: {$command}");
            }
        }
    }
}
