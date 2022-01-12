<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

/**
 * Format select's attributes.
 *
 * @param  array  $vars
 * @return HtmlString
 */
function form_control_select_attr(array $vars): HtmlString
{
    // fill-in the blanks
    $vars = form_control_base_attr($vars, ['form-control', 'shadow-sm']);

    if (!empty($vars['large'])) {
        $vars['class'][] = "form-control-lg";
    }

    if (!empty($vars['small'])) {
        $vars['class'][] = "form-control-sm";
    }

    if (!empty($vars['selectpicker'])) {
        $vars['class'][] = "selectpicker";
    }

    if (isset($vars['disabled']) && is_array($vars['disabled'])) {
        unset($vars['disabled']);
    }

    if (isset($vars['disabled']) && $vars['disabled'] === true) {
        $vars['disabled'] = true;
    }

    if (isset($vars['search']) && $vars['search'] === true) {
        $vars['_attributes'] = Arr::get($vars, '_attributes', []) + ['data-live-search' => true];
    }

    if (!empty($vars['selectpicker']) && !empty($vars['multiple'])) {
        $vars['_attributes'] = Arr::get($vars, '_attributes', []) + ['data-actions-box' => true];
    }

    $attributes = [
        'autocomplete', 'autofocus', 'disabled', 'form', 'multiple', 'name',
        'required', 'size',
    ];

    return component_attr($vars, ...$attributes);
}

/**
 * Format optgroup's attributes.
 *
 * @param  array  $vars
 * @return HtmlString
 */
function form_control_optgroup_attr(array $vars): HtmlString
{
    if (isset($vars['optgroup_label'])) {
        $vars['label'] = $vars['optgroup_label'];
    }

    if (isset($vars['disabled']) &&
        is_array($vars['disabled']) &&
        in_array($vars['optgroup_label'], $vars['disabled'], true)
    ) {
        $vars['disabled'] = true;
    } else {
        unset($vars['disabled']);
    }

    return component_attr($vars, 'disabled', 'label');
}

/**
 * Format option's attributes.
 *
 * @param  array  $vars
 * @return HtmlString
 */
function form_control_option_attr(array $vars): HtmlString
{
    unset($vars['id']);

    $value = empty($vars['ignore_keys']) ? $vars['option_value'] : $vars['option_label'];

    if (!isset($vars['value']) && isset($vars['name']) && session()->hasOldInput(rtrim($vars['name'], '.'))) {
        $vars['value'] = session()->getOldInput(rtrim($vars['name'], '.'));
    }

    if (isset($vars['value']) && in_array($value, array_wrap($vars['value']))) {
        $vars['selected'] = true;
    }

    if (empty($vars['ignore_keys'])) {
        $vars['value'] = $value;
    }

    if (isset($vars['disabled']) && is_array($vars['disabled']) && in_array($value, $vars['disabled'], true)) {
        $vars['disabled'] = true;
    } else {
        unset($vars['disabled']);
    }

    return component_attr($vars, 'disabled', 'selected', 'value');
}
