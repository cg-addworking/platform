<?php

use Illuminate\Support\HtmlString;
use Illuminate\Support\ViewErrorBag;

/**
 * Format form-group's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_group_attr(
    array    $vars,
    string  &$id = null,
    string  &$invalid_feedback = null,
    bool    &$is_invalid = null,
    bool    &$is_valid = null
): HtmlString {
    // generated id for input & label
    $id = $id ?? uniqid('form-group-');

    // fill-in the blanks
    $vars = form_control_base_attr($vars, 'form-group');

    if (isset($vars['invalid_feedback'])) {
        $invalid_feedback = $vars['invalid_feedback'];
    }

    if (isset($vars['is_invalid'])) {
        $is_invalid = $vars['is_invalid'];
    }

    if (isset($vars['is_valid'])) {
        $is_valid = $vars['is_valid'];
    }

    if (isset($vars['invalid_tooltip']) || isset($vars['valid_tooltip'])) {
        $vars['class'][] = "position-relative";
    }

    return component_attr(array_except($vars, ['id']));
}
