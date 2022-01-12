<?php

use Illuminate\Support\HtmlString;

/**
 * Format checkbox's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_checkbox_attr(array $vars): HtmlString
{
    // fill-in the blanks
    $vars = form_control_base_attr($vars, 'form-check');

    if (! empty($vars['inline'])) {
        $vars['class'][] = "form-check-inline";
    }

    return component_attr($vars);
}
