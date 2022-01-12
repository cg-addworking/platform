<?php

use Illuminate\Support\HtmlString;

// ----------------------------------------------------------------------------
// Tags Helpers
// ----------------------------------------------------------------------------

if (! function_exists('html_tag_select_attr')) {
    /**
     * Formats attributes for select HTML tag
     *
     * @param  array  $vars
     * @return Illuminate\Support\HtmlString
     */
    function html_tag_select_attr(array $vars = []): HtmlString
    {
        $attributes = [
            'name' => dot_to_input($vars['name'] ?? ''),
            'id' => $vars['id'] ?? uniqid('select_'),
        ];

        if ($vars['onchange'] ?? false) {
            $attributes += [
                'onchange' => "{$vars['onchange']}",
            ];
        }

        if ($vars['multiple'] ?? false) {
            $attributes += [
                'multiple' => "multiple",
                'data-actions-box' => "true",
            ];
        }

        if ($vars['required'] ?? false) {
            $attributes += [
                'required' => "required",
            ];
        }

        if ($vars['disabled'] ?? false) {
            $attributes += [
                'disabled' => "disabled",
            ];
        }

        if ($vars['live_search'] ?? false) {
            $attributes += [
                'data-live-search' => "true",
            ];
        }

        return attr($attributes);
    }
}

if (! function_exists('html_tag_option_attr')) {
    /**
     * Formats attributes for option HTML tag
     *
     * @param  array  $vars
     * @return Illuminate\Support\HtmlString
     */
    function html_tag_option_attr(array $vars = []): HtmlString
    {
        $attributes = [
            'value' => $vars['opt_value'] ?? '',
        ];

        if (in_array($vars['opt_value'], (array) old($vars['name'] ?? '', $vars['value'] ?? null))) {
            $attributes += [
                'selected' => "selected"
            ];
        }

        return attr($attributes);
    }
}

if (! function_exists('html_tag_checkbox_attr')) {
    /**
     * Formats attributes for checkbox input HTML tag.
     *
     * @param  array  $vars
     * @return Illuminate\Support\HtmlString
     */
    function html_tag_checkbox_attr(array $vars = []): HtmlString
    {
        $attributes = [
            'type'  => "checkbox",
            'name'  => dot_to_input($vars['name'] ?? ''),
            'value' => $vars['opt_value'] ?? '',
        ];

        if (! empty($vars['checked']) ||
            in_array($vars['opt_value'] ?? null, (array) old(rtrim($vars['name'] ?? '', '.'))) ||
            in_array($vars['opt_value'] ?? null, (array) ($vars['value'] ?? []))
        ) {
            $attributes['checked'] = "checked";
        }

        return attr($attributes);
    }
}

if (! function_exists('html_tag_input_attr')) {
    /**
     * Formats attributes for input HTML tag.
     *
     * @param  array  $vars
     * @return Illuminate\Support\HtmlString
     */
    function html_tag_input_attr(array $vars = []): HtmlString
    {
        $attributes = [
            'id'    => $vars['id'] ?? uniqid('input_'),
            'class' => $vars['class'] ?? 'form-control',
            'type'  => $vars['type'] ?? 'text',
            'name'  => dot_to_input($vars['name'] ?? ''),
        ];

        if (isset($vars['value'])) {
            $attributes += [
                'value' => old($vars['name'] ?? '', $vars['value'] ?? null),
            ];
        }

        if (isset($vars['placeholder'])) {
            $attributes += [
                'placeholder' => "{$vars['placeholder']}",
            ];
        }

        if ($vars['required'] ?? false) {
            $attributes += [
                'required' => "required",
            ];
        }

        if (isset($vars['step'])) {
            $attributes += [
                'step' => "{$vars['step']}",
            ];
        }

        if (isset($vars['min'])) {
            $attributes += [
                'min' => "{$vars['min']}",
            ];
        }

        if (isset($vars['max'])) {
            $attributes += [
                'max' => "{$vars['max']}",
            ];
        }

        if ($vars['multiple'] ?? false) {
            $attributes += [
                'multiple' => "multiple",
            ];
        }

        return attr($attributes);
    }
}

if (! function_exists('html_string')) {
    /**
     * Get the given string as HTML object
     *
     * @param  string $str
     * @return Illuminate\Support\HtmlString
     */
    function html_string(string $str, ...$args): HtmlString
    {
        if ($args) {
            $str = vsprintf($str, $args);
        }

        return new HtmlString($str);
    }
}

if (! function_exists('html_if')) {
    /**
     * Get the HTML only if $condition is true.
     *
     * @param  bool   $condition
     * @param  string $str
     * @return Illuminate\Support\HtmlString
     */
    function html_if(bool $condition, string $html): HtmlString
    {
        return html_string($condition ? $html : '');
    }
}

if (! function_exists('html_unless')) {
    /**
     * Get the HTML only unless $condition is true.
     *
     * @param  bool   $condition
     * @param  string $str
     * @return Illuminate\Support\HtmlString
     */
    function html_unless(bool $condition, string $html): HtmlString
    {
        return html_if(!$condition, $html);
    }
}

if (! function_exists('css_class')) {
    /**
     * Formats the given classe(s) into a string.
     *
     * @param  mixed  $class
     * @return string
     */
    function css_class($class): string
    {
        if (is_string($class)) {
            return trim(preg_replace('/\s{2,}/', ' ', $class));
        }

        if (is_array($class)) {
            return implode(' ', array_unique(array_filter(array_map('css_class', $class))));
        }

        return "";
    }
}

if (! function_exists('attr')) {
    /**
     * Format one (or many) attributes.
     *
     * @param  string|array $name
     * @param  string|null  $value
     * @return Illuminate\Support\HtmlString
     */
    function attr($name, $value = null): HtmlString
    {
        if (empty($name)) {
            return html_string('');
        }

        // instead of calling attr several times to pass several attributes,
        // you may pass an array of attributes whose keys are the attribute names,
        // numeric keys will be ignored and replaced with boolean attribute
        // (e.g. ['multiple', 'selected'] will be treated as ['multiple' => true,
        // 'selected' => true]).
        if (is_array($name)) {
            $str = collect($name)->map(function ($item, $key) {
                return is_numeric($key) ? [$item] : [$key, $item];
            })->reduce(function ($carry, $item) {
                return $carry . attr(...$item);
            });

            return html_string(ltrim($str));
        }

        // if the attribute's name is a callback ending in _attr then we call it
        // instead, this enable the use of @attr('callback_attr') in views
        // to wrap complex attribute computation in functions
        if (ends_with($name, '_attr') && is_callable($name)) {
            return $name($value);
        }

        // some attributes (like multiple or selected) are not sensitive to
        // their value and change element's behavior based on their presence
        // or not, we prefer to simply remove them if their value is
        // stricly false
        if ($value === false) {
            return html_string('');
        }

        return !is_null($value)
            ? html_string(' %s="%s"', $name, $value)
            : html_string(' %s', $name);
    }
}

if (! function_exists('attr_if')) {
    /**
     * Format one or many attributes for HTML if $condition is true
     *
     * @param  bool   $condition
     * @param  mixed $args
     * @return Illuminate\Support\HtmlString
     */
    function attr_if(bool $condition, ...$args): HtmlString
    {
        return $condition ? attr(...$args) : html_string('');
    }
}

if (! function_exists('attr_unless')) {
    /**
     * Format one or many attributes for HTML if $condition is false, the
     * opposite of attr_if
     *
     * @param  bool   $condition
     * @param  mixed $args
     * @return Illuminate\Support\HtmlString
     */
    function attr_unless(bool $condition, ...$args): HtmlString
    {
        return attr_if(!$condition, ...$args);
    }
}
