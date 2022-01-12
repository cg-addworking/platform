<?php

use Illuminate\Support\HtmlString;

/**
 * Format switch's attributes.
 *
 * @param  array  $vars
 * @return HtmlString
 */
function form_control_switch_attr(array $vars): HtmlString
{
    // fill-in the blanks
    $vars = form_control_base_attr($vars, ["custom-control", "custom-switch"]);

    return component_attr($vars, "disabled", "form", "name", "required");
}
