<?php

// ----------------------------------------------------------------------------
// Array Helpers
// ----------------------------------------------------------------------------

if (! function_exists('pipe_to_array')) {
    /**
     * Translates pipe notation to array.
     *
     * e.g. "foo|bar:baz|pok" becomes ['text' => "foo", 'bar' => "baz", "pok" => true]
     *
     * @param  string|array $pipe
     * @param  string       $separator
     * @return array
     */
    function pipe_to_array($pipe = ""): array
    {
        if (is_array($pipe)) {
            return $pipe;
        }

        $parts = array_filter(array_map('trim', explode('|', $pipe)));
        $array = ['text' => array_shift($parts)];

        foreach ($parts as $part) {
            if (false !== strpos($part, ':')) {
                list($name, $value) = explode(':', $part, 2);
                $array[$name] = interpolate_litteral($value);
            } else {
                $array[$part] = true;
            }
        }

        return $array;
    }
}

if (! function_exists('array_to_pipe')) {
    /**
     * Translates array to pipe notation (the inverse of pipe_to_array).
     *
     * e.g. ['text' => "foo", 'bar' => "baz", "pok" => true] becomes "foo|bar:baz|pok"
     *
     * @param  string|array $array
     * @return string
     */
    function array_to_pipe($array): string
    {
        if (is_string($array)) {
            return $array;
        }

        $slot = $array['text'] ?? "";
        unset($array['text']);

        foreach ($array as $key => &$val) {
            $val = is_bool($val) ? $key : "{$key}:{$val}";
        }

        return "{$slot}|" . implode('|', $array);
    }
}

if (! function_exists('array_alias')) {
    /**
     * Changes the aliased array keys to their real names.
     *
     * @param  array  $items
     * @param  array  $aliases
     * @return array
     */
    function array_alias(array $items, array $aliases): array
    {
        $result = [];

        foreach ($items as $key => $value) {
            $result[isset($aliases[$key]) ? $aliases[$key] : $key] = $value;
        }

        return $result;
    }
}

if (! function_exists('array_mirror')) {
    /**
     * Produces an array which values and keys are the same.
     *
     * @param  array $arr
     * @return array
     */
    function array_mirror(array $arr): array
    {
        return array_combine($arr, $arr);
    }
}

if (! function_exists('array_index')) {
    /**
     * Index a collection by the given key.
     *
     * @param  iterable $collection
     * @param  mixed    $index
     * @return array
     */
    function array_index(iterable $collection, $index)
    {
        $result = [];

        if (!is_callable($index)) {
            $index = function ($item, $key) use ($index) {
                return array_get($item, $index);
            };
        }

        foreach ($collection as $key => $item) {
            $result[$index($item, $key)][] = $item;
        }

        return $result;
    }
}

if (! function_exists('array_trans')) {
    /**
     * Translates a collection in a set of key value pairs (useful for views.)
     *
     * @param  iterable $collection
     * @param  string   $prefix
     * @return array
     */
    function array_trans(iterable $collection, $prefix = ''): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[$item] = __("{$prefix}{$item}");
        }

        return $result;
    }
}

if (! function_exists('array_trans_with_keys')) {
    /**
     * Translates a collection in a set of key value pairs (useful for view)
     *
     * @param  iterable $collection
     * @param  string   $prefix
     * @return array
     */
    function array_trans_with_keys(iterable $collection, $prefix = ''): array
    {
        $result = [];

        foreach ($collection as $key => $item) {
            $result[$key] = __("{$prefix}{$item}");
        }

        return $result;
    }
}