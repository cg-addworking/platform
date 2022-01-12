<?php

use Illuminate\Support\HtmlString;

/**
 * Format label's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_label_attr(array $vars): HtmlString
{
    $vars = array_alias($vars, [
        'valid'   => "is_valid",
        'invalid' => "is_invalid",
    ]);

    $vars['class'] = [array_get($vars, 'class', '')];

    if (isset($vars['type']) && in_array($vars['type'], ['checkbox', 'radio'])) {
        $vars['class'][] = "form-check-label";
    }

    if (!empty($vars['is_valid'])) {
        $vars['class'][] = "text-success";
    }

    if (!empty($vars['is_invalid'])) {
        $vars['class'][] = "text-danger";
    }

    return component_attr($vars, "for", "form");
}
