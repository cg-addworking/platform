<?php

use Illuminate\Support\HtmlString;

/**
 * Format form's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_attr(array $vars): HtmlString
{
    $vars['class'] = [array_get($vars, 'class', 'prevent-multiple-submits')];

    $attributes = [
        'action', 'autocomplete', 'enctype', 'method', 'name', 'novalidate', 'target',
    ];

    if (isset($vars['groups']) && has_file_input($vars['groups'])) {
        $vars['enctype'] = "multipart/form-data";
    }

    if (isset($vars['method']) && ! in_array(strtolower($vars['method']), ['post', 'get'])) {
        // revert method to POST if it's not POST or GET so it can be
        // superseeded by @method('...') blade directive
        $vars['method'] = "post";
    }

    return component_attr($vars, ...$attributes);
}

function has_file_input(array $groups): bool
{
    foreach ($groups as $group) {
        if (is_string($group)) {
            $group = pipe_to_array($group);
        }

        if (is_array($group) && isset($group['type']) && $group['type'] == "file") {
            return true;
        }
    }

    return false;
}
