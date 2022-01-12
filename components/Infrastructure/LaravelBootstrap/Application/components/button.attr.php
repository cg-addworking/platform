<?php

use Illuminate\Support\HtmlString;

/**
 * Format button's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function button_attr(array $vars): HtmlString
{
    $vars = array_alias($vars, [
        'lg' => "large",
        'sm' => "small",
    ]);

    // @todo legacy behavior to be remowed
    if (!empty($vars['color']) && starts_with($vars['color'], 'outline-')) {
        $vars['outline'] = true;
        $vars['color'] = substr($vars['color'], 8);
    }

    $color = (! empty($vars['outline']) ? 'btn-outline-' : 'btn-') . ($vars['color'] ?? 'primary');
    unset($vars['color']);

    $vars['class'] = [array_get($vars, 'class', ''), 'btn', $color];

    if (!empty($vars['large'])) {
        $vars['class'][] = "btn-lg";
    }

    if (!empty($vars['small'])) {
        $vars['class'][] = "btn-sm";
    }

    if (!empty($vars['block'])) {
        $vars['class'][] = "btn-block";
    }

    if (!empty($vars['active'])) {
        $vars['class'][] = "active";
    }

    if (!empty($vars['confirm'])) {
        $onclick = is_string($vars['confirm']) ? "confirm('{$vars['confirm']}')" : 'confirm()';

        array_set($vars, '_attributes.onclick', array_has($vars, '_attributes.onclick')
            ? "if({$onclick}){{$vars['_attributes']['onclick']}}"
            : "return {$onclick}");
    }

    return component_attr($vars, 'href', 'class', 'target', 'type', 'name', 'value', 'disabled');
}
