<?php

use Illuminate\Support\HtmlString;

/**
 * Format textarea's attributes.
 *
 * @param  array  $vars
 * @return HtmlString
 */
function form_control_textarea_attr(array $vars): HtmlString
{
    // fill-in the blanks
    $vars = form_control_base_attr($vars, "form-control");

    $attributes = [
        "autocomplete", "autofocus", "cols", "disabled", "form", "maxlength",
        "minlength", "name", "placeholder", "readonly", "required", "rows",
        "spellcheck", "wrap",
    ];

    return component_attr($vars, ...$attributes);
}
