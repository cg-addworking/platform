<?php

use Illuminate\Support\ViewErrorBag;

/**
 * Determines the Bootstrap 4 utilities classes from given variables array.
 *
 * @param  array  $vars
 * @return array
 */
function utility_classes(array $vars): array
{
    $vars = array_alias($vars, [
        'bg' => "background_color",
        'sr' => "screen_reader",
        'w'  => "width",
        'h'  => "height",
        'mw' => "max_width",
        'mh' => "max_height",
        'm'  => "margin",
        'mt' => "margin_top",
        'mr' => "margin_right",
        'mb' => "margin_bottom",
        'ml' => "margin_left",
        'mx' => "margin_horizontal",
        'my' => "margin_vertical",
        'p'  => "padding",
        'pt' => "padding_top",
        'pr' => "padding_right",
        'pb' => "padding_bottom",
        'pl' => "padding_left",
        'px' => "padding_horizontal",
        'py' => "padding_vertical",
    ]);

    $classes = [];

    // @see https://getbootstrap.com/docs/4.2/utilities/borders/
    if (! empty($vars['border'])) {
        $classes[] = $vars['border'] === true ? "border" : "border-{$vars['border']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/borders/#border-color
    if (! empty($vars['border_color'])) {
        $classes[] = "border border-{$vars['border-color']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/borders/#border-radius
    if (! empty($vars['border_radius'])) {
        $classes[] = $vars['border_radius'] === true ? "rounded" : "rounded-{$vars['border_radius']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/colors/
    if (! empty($vars['color'])) {
        $classes[] = "text-{$vars['color']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/colors/
    if (! empty($vars['background_color'])) {
        $classes[] = "bg-{$vars['background_color']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/flex/
    if (! empty($vars['flex'])) {
        $classes[] = $vars['flex'] === true ? 'd-flex' : "d-{$vars['flex']}-flex";

        // @todo handle rows, columns, justify-content, align, fill, etc. here!
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/float/
    if (! empty($vars['float'])) {
        $classes[] = "float-{$vars['float']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/overflow/
    if (! empty($vars['overflow'])) {
        $classes[] = "overflow-{$vars['overflow']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/position/
    if (! empty($vars['position'])) {
        $classes[] = starts_with($vars['position'], 'fixed-') ? $vars['position'] : "position-{$vars['position']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/screen-readers
    if (! empty($vars['screen_reader'])) {
        $classes[] = ["sr-only", $vars['screen-reader'] == 'focusable' ? 'sr-only-focusable' : ''];
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/shadows/
    if (! empty($vars['shadow'])) {
        $classes[] = $vars['shadow'] === true ? "shadow" : "shadow-{$vars['shadow']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/sizing/
    if (! empty($vars['width'])) {
        $classes[] = "w-{$vars['width']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/sizing/
    if (! empty($vars['height'])) {
        $classes[] = "h-{$vars['height']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/sizing/
    if (! empty($vars['max_width'])) {
        $classes[] = "mw-{$vars['max_width']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/sizing/
    if (! empty($vars['max_height'])) {
        $classes[] = "mh-{$vars['max-height']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin'])) {
        $classes[] = "m-{$vars['margin']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_top'])) {
        $classes[] = "mt-{$vars['margin_top']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_right'])) {
        $classes[] = "mr-{$vars['margin_right']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_bottom'])) {
        $classes[] = "mb-{$vars['margin_bottom']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_left'])) {
        $classes[] = "ml-{$vars['margin_left']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_horizontal'])) {
        $classes[] = "mx-{$vars['margin_horizontal']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['margin_vertical'])) {
        $classes[] = "my-{$vars['margin_vertical']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding'])) {
        $classes[] = "m-{$vars['padding']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_top'])) {
        $classes[] = "mt-{$vars['padding_top']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_right'])) {
        $classes[] = "mr-{$vars['padding_right']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_bottom'])) {
        $classes[] = "mb-{$vars['padding_bottom']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_left'])) {
        $classes[] = "ml-{$vars['padding_left']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_horizontal'])) {
        $classes[] = "mx-{$vars['padding_horizontal']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/spacing/
    if (! empty($vars['padding_vertical'])) {
        $classes[] = "my-{$vars['padding_vertical']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['text_align'])) {
        $classes[] = "text-{$vars['text_align']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['text_wrapping'])) {
        $classes[] = "text-{$vars['text-wrapping']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['text_transform'])) {
        $classes[] = "text-{$vars['text-transform']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['font_weight'])) {
        $classes[] = "text-{$vars['font_weight']}";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['font_italic'])) {
        $classes[] = "font-italic";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/text/
    if (! empty($vars['text_monospace'])) {
        $classes[] = "text-monospace";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/visibility/
    if (! empty($vars['invisible'])) {
        $classes[] = "invisible";
    }

    // @see https://getbootstrap.com/docs/4.2/utilities/visibility/
    if (! empty($vars['visible'])) {
        $classes[] = "visible";
    }

    return $classes;
}

/**
 * Determines the Bootstrap 4 form-control classes variants from given variables array.
 *
 * @param  array  $vars
 * @return array
 */
function form_control_classes(array $vars): array
{
    $vars = array_alias($vars, [
        'lg'      => "large",
        'sm'      => "small",
        'valid'   => "is_valid",
        'invalid' => "is_invalid",
    ]);

    $classes = [];

    if (isset($vars['large'])) {
        $classes[] = "form-control-lg";
    }

    if (isset($vars['small'])) {
        $classes[] = "form-control-sm";
    }

    if (isset($vars['plaintext'])) {
        $classes[] = "form-control-plaintext";
    }

    if (!empty($vars['is_valid'])) {
        $classes[] = "is-valid";
    }

    if (!empty($vars['is_invalid'])) {
        $classes[] = "is-invalid";
    }

    return $classes;
}

/**
 * Determines the base variables that all form control share and rely upon.
 *
 * @param  array  $vars
 * @param  mixed  $class
 * @return array
 */
function form_control_base_attr(array $vars, $class = null): array
{
    // an input with an old value that is not referenced on the $errors
    // variable (ViewErrorBag provided by Laravel with $request->validate)
    // is considered valid
    if (isset($vars['name'], $vars['errors']) &&
        $vars['errors'] instanceof ViewErrorBag &&
        !$vars['errors']->has(rtrim($vars['name'], '.')) &&
        session()->hasOldInput(rtrim($vars['name'], '.'))
    ) {
        $vars['is_valid'] = true;
    }

    // populates automatically the $invalid_feedback with the first
    // error encountered for that field (identified by its name) if
    // necessary
    if (isset($vars['errors'], $vars['name']) &&
        $vars['errors'] instanceof ViewErrorBag &&
        $vars['errors']->has(rtrim($vars['name'], '.'))
    ) {
        $vars['invalid_feedback'] = $vars['errors']->first(rtrim($vars['name'], '.'));
        $vars['is_invalid'] = true;
    }

    // pull the previous value from the session if it exists
    // so that the user doesn't need to re-fill them in case of
    // form validation failure
    if (!isset($vars['value']) && isset($vars['name']) && session()->hasOldInput(rtrim($vars['name'], '.'))) {
        $vars['value'] = session()->getOldInput(rtrim($vars['name'], '.'));
    }

    // automatically converts dot notation (a.b.c) to HTML input name
    // notation (a[b][c])
    if (isset($vars['name'])) {
        $vars['name'] = dot_to_input($vars['name']);
    }

    // base classes that should be available for all form-control plus the
    // classes that were eventually passed manually to the component plus
    // the class(es) passed to the function
    $vars['class'] = [array_get($vars, 'class', ''), form_control_classes($vars), $class];

    return $vars;
}
