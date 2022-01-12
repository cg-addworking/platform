<?php

use Illuminate\Support\HtmlString;

/**
 * Format anchor's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function anchor_attr(array $vars): HtmlString
{
    return component_attr($vars, 'class', 'href', 'target');
}
