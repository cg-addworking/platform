<?php

namespace Components\Infrastructure\Foundation\Application\Test;

use Illuminate\Support\Arr;

class Printer
{
    public static $colors = [
        'black'         => "0;30",
        'red'           => "0;31",
        'green'         => "0;32",
        'brown'         => "0;33",
        'blue'          => "0;34",
        'magenta'       => "0;35",
        'cyan'          => "0;36",
        'light-grey'    => "0;37",
        'dark-grey'     => "1;30",
        'light-red'     => "1;31",
        'light-green'   => "1;32",
        'yellow'        => "1;33",
        'light-blue'    => "1;34",
        'light-magenta' => "1;35",
        'light-cyan'    => "1;36",
        'white'         => "1;37",
    ];

    public static function print($message, ...$args)
    {
        fwrite(STDOUT, self::colorize($message, $args));
    }

    public static function colorize(string $message, ...$args): string
    {
        $message = vsprintf($message, Arr::flatten($args));

        // are we running inside a terminal?
        if (! stream_isatty(STDOUT)) {
            return $message; // no colors
        }

        foreach (static::$colors as $color => $code) {
            $message = preg_replace("#<{$color}>([^<]*)</{$color}>#", "\e[{$code}m$1\e[0m", $message);
        }

        return $message;
    }
}
