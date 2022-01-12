<div {{ form_group_attr(get_defined_vars(), $id, $invalid_feedback, $is_invalid, $is_valid) }}>
    @include('bootstrap::form.control.label', ['id' => null, 'for' => $id])
    @if (! isset($slot) || strlen(trim($slot)) == 0)
        @include('bootstrap::form.control', ['id' => $id, 'text' => null])
    @else
        {{ $slot }}
    @endif

    @isset($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endisset

    @isset($valid_feedback)
        <div class="valid-feedback">{{ $valid_feedback }}</div>
    @endisset

    @isset($invalid_feedback)
        <div class="invalid-feedback">{{ $invalid_feedback }}</div>
    @endisset

    @isset($valid_tooltip)
        <div class="valid-tooltip">{{ $valid_tooltip }}</div>
    @endisset

    @isset($invalid_tooltip)
        <div class="invalid-tooltip">{{ $invalid_tooltip }}</div>
    @endisset
</div>
