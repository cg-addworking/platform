<?php

use Illuminate\Support\HtmlString;

/**
 * Format input's attributes.
 *
 * @param  array  $vars
 * @return HtmlSring
 */
function form_control_input_attr(array $vars): HtmlString
{
    // defaults to type="text"
    if (empty($vars['type'])) {
        $vars['type'] = "text";
    }

    // use $text as value attribute e.g. @input('value')
    if (isset($vars['text'])) {
        $vars['value'] = $vars['text'];
    }

    // fill-in the blanks
    $vars = form_control_base_attr($vars);

    // determine the proper form-control class to use
    switch ($vars['type']) {
        case 'file':
            $vars['class'][] = "form-control-file";
            break;

        case 'range':
            $vars['class'][] = "form-control-range";
            break;

        case 'checkbox':
        case 'radio':
            $vars['class'][] = "form-check-input";
            break;

        default:
            $vars['class'][] = "form-control";
            break;
    }

    $vars['class'][] = "shadow-sm";

    // checkbox & radio input are usually accompanied by a label, the
    // $without_label var let the form builder avoid that if necessary
    if (!empty($vars['without_label']) && in_array($vars['type'], ['checkbox', 'radio'])) {
        $vars['class'][] = "position-static";
        $vars['aria-label'] = $vars['text'] ?? '';
    }

    // add checked attribute if necessary
    if (in_array($vars['type'], ['checkbox', 'radio']) &&
        isset($vars['name'], $vars['value']) &&
        in_array($vars['value'], array_wrap(old(rtrim(input_to_dot($vars['name']), '.'))))
    ) {
        $vars['checked'] = true;
    }

    // remove the checked attribute if necessary (e.g. with '...|checked:false')
    if (isset($vars['checked']) && $vars['checked'] == false) {
        unset($vars['checked']);
    }

    if (isset($vars['type'], $vars['value']) &&
        $vars['type'] == 'date' &&
        $vars['value'] instanceof DateTime
    ) {
        $vars['value'] = $vars['value']->format('Y-m-d');
    }

    if (isset($vars['type'], $vars['value']) &&
        $vars['type'] == 'datetime-local' &&
        $vars['value'] instanceof DateTime
    ) {
        $vars['value'] = $vars['value']->format('Y-m-d\TH:i');
    }

    // determine the suitable attributes for this input
    // @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
    $common_attr = [
        'autocomplete', 'autofocus', 'disabled', 'form', 'list', 'name',
        'readonly', 'required', 'tabindex', 'type', 'value',
    ];

    if ($vars['type'] == "text") {
        $attributes = array_merge(
            ['maxlength', 'minlength', 'pattern', 'placeholder', 'readonly', 'size', 'spellcheck'],
            $common_attr
        );
    }

    if ($vars['type'] == "number") {
        $attributes = array_merge(
            ['min', 'max', 'placeholder', 'readonly', 'step'],
            $common_attr
        );
    }

    if ($vars['type'] == "date") {
        $attributes = array_merge(
            ['min', 'max', 'readonly', 'step'],
            $common_attr
        );
    }

    if ($vars['type'] == "password") {
        $attributes = array_merge(
            ['maxlength', 'minlength', 'pattern', 'placeholder', 'readonly', 'size'],
            $common_attr
        );
    }

    if ($vars['type'] == "checkbox") {
        $attributes = array_merge(
            ["checked"],
            $common_attr
        );
    }

    if ($vars['type'] == "radio") {
        $attributes = array_merge(
            ["checked"],
            $common_attr
        );
    }

    if ($vars['type'] == "search") {
        $attributes = array_merge(
            ["maxlength", "minlength", "pattern", "placeholder", "readonly", "size", "spellcheck"],
            $common_attr
        );
    }

    if ($vars['type'] == "tel") {
        $attributes = array_merge(
            ["maxlength", "minlength", "pattern", "placeholder", "readonly", "size"],
            $common_attr
        );
    }

    if ($vars['type'] == "url") {
        $attributes = array_merge(
            ["maxlength", "minlength", "pattern", "placeholder", "readonly", "size", "spellcheck"],
            $common_attr
        );
    }

    if ($vars['type'] == "datetime-local") {
        $attributes = array_merge(
            ["max", "min", "readonly", "step"],
            $common_attr
        );
    }

    if ($vars['type'] == "color") {
        $attributes = array_merge(
            [],
            $common_attr
        );
    }

    if ($vars['type'] == "email") {
        $attributes = array_merge(
            ["maxlength", "minlength", "multiple", "pattern", "placeholder", "readonly", "size", "spellcheck"],
            $common_attr
        );
    }

    if ($vars['type'] == "file") {
        $attributes = array_merge(
            ["accept", "capture", "files", "multiple"],
            $common_attr
        );
    }

    if ($vars['type'] == "hidden") {
        $attributes = array_merge(
            [],
            $common_attr
        );
    }

    if ($vars['type'] == "month") {
        $attributes = array_merge(
            ["max", "min", "readonly", "step"],
            $common_attr
        );
    }

    if ($vars['type'] == "range") {
        $attributes = array_merge(
            ["max", "min", "step"],
            $common_attr
        );
    }

    if ($vars['type'] == "time") {
        $attributes = array_merge(
            ["max", "min", "readonly", "step"],
            $common_attr
        );
    }

    if ($vars['type'] == "week") {
        $attributes = array_merge(
            ["max", "min", "readonly", "step"],
            $common_attr
        );
    }

    return component_attr($vars, ...$attributes);
}
