#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

exit(main($argc, $argv));

function main(int $argc, array $argv): int
{
    $options = "--cached --no-ext-diff --unified=0 --exit-code -a --no-prefix";
    $diff    = (string) shell_exec("git diff HEAD {$options} | egrep \"^\+\"");
    $result  = check_tests($diff);

    return (int) (!$result);
}

function should_ignore(string $class): bool
{
    static $ignored = [
        'App\Http\Kernel',
    ];

    if (in_array($class, $ignored)) {
        return true;
    }

    if (strpos($class, 'Tests\\') === 0) {
        return true;
    }

    return false;
}

function check_tests(string $diff): int
{
    $lines  = explode("\n", $diff);
    $return = true;

    foreach ($lines as $line) {
        // diff lines begining with +++ are modified file's names
        if (strpos($line, '+++') === 0) {
            unset($class);

            // is it a PHP file?
            if (! preg_match('/\.php$/', $line)) {
                continue;
            }

            // attempt to get classname from filename
            // (note: laravel uses app/ for App\ namespace)
            $class = str_replace(['app/', 'tests/'], ['App/', 'Tests/'], substr($line, 4, -4));
            $class = str_replace('/', '\\', $class);

            // is this file a class? if not, just ignore the rest
            // until next file
            if (! class_exists($class, true)) {
                unset($class);
                continue;
            }

            // should this class be tested?
            if (should_ignore($class)) {
                unset($class);
                continue;
            }

            // does this class have a test?
            if (! class_exists($test_class = "Tests\\Unit\\{$class}Test", true)) {
                printf("No test found for %s\n", double_escape($class));
                $return = false;
            }

            continue;
        }

        // diff lines begining with + are modified code lines
        // is this line a method declaration?
        if (isset($class) && strpos($line, '+') === 0 && preg_match('/public function (\w+)\(/', $line, $matches)) {
            list(, $method) = $matches;
            $test_method = "test" . ucfirst(str_replace('__', '', $method));

            // if the test class exists but not the test method
            if (class_exists($test_class, true) && ! method_exists($test_class, $test_method)) {
                printf("No test found for %s::%s\n", double_escape($class), $method);
                $return = false;
            }
        }
    }

    return $return;
}

function double_escape(string $class)
{
    return str_replace('\\', '\\\\', $class);
}
