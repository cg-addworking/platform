@if (isset($text))
    @php
        $options = explode(',', $text);
    @endphp
@endisset

@if (isset($value) && $value instanceof Illuminate\Support\Collection)
    @php
        $value = collect($value)->map(function ($value) {
            return $value instanceof Illuminate\Database\Eloquent\Model && $value->exists ? $value->id : $value;
        })->all();
    @endphp
@endisset

<select @attr('form_control_select_attr')>
    @if (isset($slot) && trim($slot))
        {{ $slot }}
    @else
        @if (empty($required) && empty($multiple))
            <option value=""></option>
        @endif

        @foreach ($options ?? [] as $option_value => $option_label)
            @if (is_iterable($option_label))
                @php
                    $optgroup_label  = $option_value;
                    $optgroup_values = $option_label;
                @endphp
                <optgroup @attr('form_control_optgroup_attr')>
                    @foreach ($optgroup_values as $option_value => $option_label)
                        <option @attr('form_control_option_attr')>{{ $option_label }}</option>
                    @endforeach
                </optgroup>
            @else
                <option @attr('form_control_option_attr')>{{ $option_label }}</option>
            @endif
        @endforeach
    @endif
</select>
