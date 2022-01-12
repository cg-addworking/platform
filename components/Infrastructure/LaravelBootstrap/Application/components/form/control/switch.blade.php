<div @attr('form_control_switch_attr')>
    @include('bootstrap::form.control.input', [
        'type'  => "checkbox",
        'class' => "custom-control-input",
        'text'  => null,
        'id'    => $id = uniqid('form-switch-')
    ])
    @includeWhen(empty($without_label), 'bootstrap::form.control.label', [
        'type'  => "checkbox",
        'class' => "custom-control-label",
        'text'  => $text ?? $slot ?? '',
        'for'   => $id,
        'id'    => null,
        'hide_required_asterisk' => true
    ])
</div>
