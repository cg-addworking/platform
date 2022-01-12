<?php

use Illuminate\Support\HtmlString;

/**
 * Format variables into HTML tag attributes.
 *
 * @param  array  $vars
 * @param  array  $attr
 * @return HtmlString
 */
function component_attr(array $vars, ...$attr): HtmlString
{
    // format the CSS classes and eventually pad them with the Bootstrap
    // utility classes
    $vars['class'] = css_class([array_get($vars, 'class', ''), utility_classes($vars)]);

    if (!$vars['class']) {
        unset($vars['class']);
    }

    // adding default, always available, attributes
    $attr = array_merge($attr, ['id', 'style', 'class']);

    // attributes placed on the special key _attributes take precedence
    // over computed ones so it is possible to force their value
    $attributes = array_get($vars, '_attributes', []) + array_only($vars, $attr);

    return attr($attributes);
}
