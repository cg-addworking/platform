<?php

use Illuminate\Support\HtmlString;

/**
 * Format radio's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_radio_attr(array $vars): HtmlString
{
    return form_control_checkbox_attr($vars);
}
