<?php

use Illuminate\Support\HtmlString;

/**
 * Format button's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function dropdown_attr(array $vars): HtmlString
{
    $vars['class'] = [array_get($vars, 'class', ''), "dropdown"];

    switch ($vars['direction'] ?? '') {
        case 'up':
            $vars['class'][] = "dropup";
            break;
        case 'right':
            $vars['class'][] = "dropright";
            break;
        case 'left':
            $vars['class'][] = "dropleft";
            break;
    }

    return component_attr($vars, 'class');
}
