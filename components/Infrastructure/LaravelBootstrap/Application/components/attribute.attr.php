<?php

use Illuminate\Support\HtmlString;

/**
 * Format icon's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function attribute_attr(array $vars): HtmlString
{
    $vars['class'] = ["mb-3", $vars['class'] ?? ''];

    return component_attr($vars, 'class');
}
