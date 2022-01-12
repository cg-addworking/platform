<?php

use Illuminate\Support\HtmlString;

/**
 * Format checkbox_list's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_checkbox_list_attr(array $vars): HtmlString
{
    $vars['class'] = [array_get($vars, 'class', ''), "form-check-list"];

    if (!empty($vars['inline'])) {
        $vars['class'][] = "form-check-inline";
    }

    return component_attr($vars);
}
