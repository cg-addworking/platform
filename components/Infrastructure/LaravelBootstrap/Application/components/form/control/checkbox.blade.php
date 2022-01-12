<div @attr('form_control_checkbox_attr')>
    @include('bootstrap::form.control.input', [
        'type' => "checkbox",
        'text' => null,
        'id'   => $id = uniqid('form-check-')
    ])
    @includeWhen(empty($without_label), 'bootstrap::form.control.label', [
        'type' => "checkbox",
        'text' => $text ?? $slot ?? '',
        'for'  => $id,
        'id'   => null,
        'hide_required_asterisk' => true
    ])
</div>
