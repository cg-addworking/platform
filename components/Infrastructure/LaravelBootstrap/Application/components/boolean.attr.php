<?php

use Illuminate\Support\HtmlString;

/**
 * Format button's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function boolean_attr(array $vars): HtmlString
{
    $vars['class'] = [array_get($vars, 'class')];

    if (isset($vars['value']) && $vars['value'] === true) {
        $vars['class'][] = "text-success";
    }

    if (isset($vars['value']) && $vars['value'] === false) {
        $vars['class'][] = "text-danger";
    }

    if (! isset($vars['value'])) {
        $vars['class'][] = "text-muted";
    }

    return component_attr($vars, 'class');
}
