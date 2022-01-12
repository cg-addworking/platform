<?php

use Illuminate\Support\HtmlString;

/**
 * Format radio_list's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_radio_list_attr(array $vars): HtmlString
{
    return form_control_checkbox_list_attr($vars);
}
