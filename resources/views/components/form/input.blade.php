<input
    id="{{ $id ?? uniqid('input_') }}"
    type="{{ $type ?? 'text' }}"
    name="{{ dot_to_input($name) }}"
    value="{{ old($name, $value ?? null) }}"
    placeholder="{{ $placeholder ?? '' }}"
    class="form-control {{ $class ?? '' }}"
    {{ ($required ?? false) ? ' required' : '' }}
    {{ ($step ?? false) ? " step={$step}" : '' }}
    {{ isset($min) ? " min={$min}" : '' }}
    {{ isset($max) ? " max={$max}" : '' }}
    >
