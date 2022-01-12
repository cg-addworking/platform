@if (isset($text))
    @php
        $options = explode(',', $text);
    @endphp
@endisset
<div @attr('form_control_checkbox_list_attr')>
    @foreach(array_wrap($options ?? []) as $option_value => $option_label)
        @include('bootstrap::form.control.checkbox', [
            'text'    => $option_label,
            'value'   => $option_value,
            'checked' => isset($value) && in_array($option_value, array_wrap($value)),
        ])
    @endforeach
</div>
