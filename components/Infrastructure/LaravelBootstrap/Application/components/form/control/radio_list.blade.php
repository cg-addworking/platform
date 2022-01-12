@isset($text)
    @php
        $options = explode(',', $text);
    @endphp
@endisset
<div @attr('form_control_radio_list_attr')>
    @foreach(array_wrap($options ?? []) as $option_value => $option_label)
        @include('bootstrap::form.control.radio', ['text' => $option_label, 'value' => $option_value])
    @endforeach
</div>
