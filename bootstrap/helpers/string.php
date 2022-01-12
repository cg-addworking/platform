<?php

// ----------------------------------------------------------------------------
// String Helpers
// ----------------------------------------------------------------------------

if (! function_exists('badge_color')) {
    /**
     * Get the hashing color for the given string
     *
     * @param  string $str
     * @return string
     */
    function badge_color(string $str, array $colors = null): string
    {
        $colors = $colors ?? ['default', 'primary', 'success', 'info', 'warning', 'danger'];

        return $colors[crc32($str) % count($colors)];
    }
}

if (! function_exists('short_string')) {
    /**
     * Limit the size of a string
     *
     * @param  string $str
     * @param  int $limit
     * @return string
     */
    function short_string(string $str, int $limit): string
    {
        if (strlen($str) > $limit) {
            return substr($str, 0, $limit) . '...';
        }

        return $str;
    }
}

if (! function_exists('interpolate_litteral')) {
    /**
    * Interpolates a litteral expression to its value (e.g. 'true' becomes TRUE).
     *
     * @param  string $value
    * @return mixed
        */
    function interpolate_litteral(string $value)
    {
        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if ($value === 'null') {
            return null;
        }

        if (is_numeric($value)) {
            return floatval($value);
        }

        return $value;
    }
}

if (! function_exists('ngram')) {
    /**
     * Return the string of characters corresponding most to the searched string.
     *
     * @param  string $str
     * @param  int    $length
     * @return array
     */
    function ngram(string $str, int $length = 3): array
    {
        if (empty($str)) {
            return [];
        }

        $ngram = [];
        $str = str_repeat(' ', $length - 1) . $str;
        for ($i = 0; $i < strlen($str); $i++) {
            $ngram[] = trim(substr($str, $i, $length));
        }

        return $ngram;
    }
}

if (! function_exists('input_to_dot')) {
    /**
     * Converts HTML input names to dot notation e.g. 'foo[bar]' will become 'foo.bar'.
     *
     * @param  string $name
     * @return string
     */
    function input_to_dot(string $name): string
    {
        if (!preg_match_all('/\[([^\]]*)\]/', $name, $matches)) {
            return $name;
        }

        foreach ($matches[1] as &$match) {
            $match = ".{$match}";
        }

        return str_replace($matches[0], $matches[1], $name);
    }
}

if (! function_exists('dot_to_input')) {
    /**
     * Converts dot notation to HTML input names e.g. 'foo.bar' will become 'foo[bar]'.
     *
     * @param  string $name
     * @return string
     */
    function dot_to_input(string $name): string
    {
        if (false === strpos($name, '.')) {
            return $name;
        }

        $parts = explode('.', $name);
        $first = array_shift($parts);

        foreach ($parts as &$part) {
            $part = "[$part]";
        }

        return $first . implode('', $parts);
    }
}

if (! function_exists('class_to_dot')) {
    /**
     * Converts classname to dot notation (e.g. 'Foo\\Bar' will become 'foo.bar').
     *
     * @param  string $name
     * @return string
     */
    function class_to_dot(string $name): string
    {
        $parts = explode('\\', $name);

        foreach ($parts as &$part) {
            $part = snake_case($part);
        }

        return implode('.', $parts);
    }
}

if (! function_exists('dot_to_class')) {
    /**
     * Converts dot notation to classsname (e.g. 'foo.bar' will become 'Foo\Bar').
     *
     * @param  string $name
     * @return string
     */
    function dot_to_class(string $name): string
    {
        $parts = explode('.', $name);

        foreach ($parts as &$part) {
            $part = studly_case($part);
        }

        return implode('\\', $parts);
    }
}

if (! function_exists('dot_to_path')) {
    /**
     * Converts dot notation to path (e.g. 'foo.bar' will become 'Foo/Bar').
     *
     * @param  string $name
     * @return string
     */
    function dot_to_path(string $name): string
    {
        $parts = explode('.', $name);

        foreach ($parts as &$part) {
            $part = studly_case($part);
        }

        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}

if (! function_exists('remove_accents')) {
    /**
     * Removes accents.
     *
     * @param  string $str
     * @param  string $charset
     * @return string
     */
    function remove_accents(string $str, string $charset = 'utf-8'): string
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace(
            '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#',
            '\1',
            $str
        );
        // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // supprime les autres caractères
        $str = preg_replace('#&[^;]+;#', '', $str);

        return $str;
    }
}

if (! function_exists('str_max')) {
    /**
     * Cuts the string if it's longer than $max characters, cut it and append $elipsis.
     *
     * @param  string $str
     * @param  int    $max
     * @param  string $ellipsis
     * @return string
     */
    function str_max(string $str = null, int $max, string $ellipsis = '…', int $min = 0): string
    {
        return mb_strimwidth($str, $min, $max, $ellipsis);
    }
}

if (! function_exists('human_filesize')) {
    /**
     * Get the filesize in human readable format.
     *
     * @param  int $bytes
     * @param  int $decimals
     * @return string
     */
    function human_filesize(int $bytes, int $decimals = 2): string
    {
        static $sizes = ['O', 'Ko', 'Mo', 'Go', 'To', 'Po'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), @$sizes[$factor]);
    }
}

if (! function_exists('is_email')) {
    /**
     * Checks whenever a given string is a valid email address.
     *
     * @param  string  $str
     * @return boolean
     */
    function is_email($str): bool
    {
        return is_string($str) && filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
    }
}
