<?php

use Illuminate\Support\HtmlString;

/**
 * Format id's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function id_attr(array $vars): HtmlString
{
    $vars['title'] = $vars['label'] ?? $vars['slot'] ?? '';

    return component_attr($vars, 'class', 'title');
}
