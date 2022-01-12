<ul id="{{ $id ?? uniqid('field_') }}" class="list-group mb-3 checkbox-list" style="max-height: {{ $height ?? '20em' }}; overflow-y: auto">
    @isset($select_all)
        <li class="list-group-item checkbox mt-0">
            <label><input type="checkbox" id="checkbox-select-all">&nbsp;{{ __('components.form.checkbox_list.select_all') }}</label>
        </li>
        @push('scripts-stack')
            <script>
                $(function () {
                    $('#checkbox-select-all').click(function () {
                        $(this).closest('ul').find(':checkbox').prop('checked', $(this).is(':checked'));
                    });
                })
            </script>
        @endpush
    @endif

    @forelse ($values ?? $options ?? [] as $opt_value => $opt_name)
        <li class="list-group-item {{ ($radio ?? false) ? 'radio' : 'checkbox' }} mt-0">
            <label><input type="{{ ($radio ?? false) ? 'radio' : 'checkbox' }}" name="{{ dot_to_input($name) }}" value="{{ $opt_value }}"{{ in_array($opt_value, (array) old(rtrim($name, '.'), $value ?? null)) ? ' checked' : '' }}>&nbsp;{{ $opt_name }}</label>
        </li>
    @empty
        <li class="list-group-item">@lang('messages.empty')</li>
    @endforelse
</ul>
