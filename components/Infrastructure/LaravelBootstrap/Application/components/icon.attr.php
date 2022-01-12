<?php

use Illuminate\Support\HtmlString;

/**
 * Format icon's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function icon_attr(array $vars): HtmlString
{
    $vars['class'] = ["fas", "fa-fw", "fa-" . array_get($vars, 'text', 'circle'), array_get($vars, 'class')];

    return component_attr($vars, 'class');
}
