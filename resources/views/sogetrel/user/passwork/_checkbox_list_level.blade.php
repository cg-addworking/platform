<ul id="{{ $id }}" class="list-group mb-3 checkbox-list">
    @foreach ($values ?? $options ?? [] as $opt_value => $opt_name)
        <li class="list-group-item checkbox mt-0">
            @if (is_array($opt_name))
                <label>
                    <input type="checkbox" disabled>&nbsp;{{ $opt_value }}
                </label>

                <ul class="m-0 my-3 p-0">
                    @foreach ($opt_name as $opt_value => $sub_opt_name)
                        <li class="list-group-item">
                            <label>
                                <input {{ html_tag_checkbox_attr(get_defined_vars()) }}>&nbsp;{{ $sub_opt_name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            @else
                <label>
                    <input {{ html_tag_checkbox_attr(get_defined_vars()) }}>&nbsp;{{ $opt_name }}
                </label>
            @endif
        </li>
    @endforeach
</ul>
