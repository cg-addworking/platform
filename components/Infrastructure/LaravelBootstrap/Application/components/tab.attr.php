<?php

use Illuminate\Support\HtmlString;

/**
 * Format tab's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function tab_attr(array $vars): HtmlString
{
    $vars['class'] = ["nav-item" ,"nav-link", $vars['class'] ?? ''];

    if (!empty($vars['active'])) {
        $vars['class'][] = "active";
    }

    if (isset($vars['name'])) {
        $vars['id'] = "nav-{$vars['name']}-tab";
        $vars['aria-controls'] = "nav-{$vars['name']}";
        $vars['href'] = "#nav-{$vars['name']}";
    }

    $vars['data-toggle'] = "tab";
    $vars['role'] = "tab";

    return component_attr($vars, 'class', 'id', 'aria-controls', 'href', 'data-toggle', 'role');
}
