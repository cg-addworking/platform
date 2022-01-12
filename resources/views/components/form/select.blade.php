<select class="form-control selectpicker" {{ html_tag_select_attr(get_defined_vars()) }}>
    @if (!($multiple ?? false))
        <option value="">@lang('messages.select')</option>
    @endif

    @foreach ($values ?? $options ?? [] as $opt_value => $opt_name)
        @if (is_array($opt_name))
            <optgroup label="{{ $opt_value }}">
                @foreach ($opt_name as $opt_value => $sub_opt_name)
                    <option {{ html_tag_option_attr(get_defined_vars()) }}>{{ $sub_opt_name }}</option>
                @endforeach
            </optgroup>
        @else
            <option {{ html_tag_option_attr(get_defined_vars()) }}>{{ $opt_name }}</option>
        @endif
    @endforeach
</select>
