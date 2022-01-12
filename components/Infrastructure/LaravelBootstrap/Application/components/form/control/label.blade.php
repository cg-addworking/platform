<label @attr('form_control_label_attr')>
    {{ $text ?? $slot ?? "" }}
    @if (! empty($required) && empty($hide_required_asterisk))
        <sup class="@if(isset($is_valid)) text-success @else text-danger @endif font-italic">*</sup>
    @endif
</label>
