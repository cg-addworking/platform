@switch($type ?? 'text')
    @case('date')
        @include('components.form.date', ['id' => $id ?? null])
        @break

    @case('textarea')
        @include('components.form.textarea', ['id' => $id ?? null])
        @break

    @case('select')
        @include('components.form.select', ['id' => $id ?? null])
        @break

    @case('file')
        @include('components.form.file', ['id' => $id ?? null])
        @break

    @case('checkbox_list')
        @include('components.form.checkbox_list', ['id' => $id ?? null])
        @break

     @case('checkbox_list_level')
        @include('components.form.checkbox_list_level', ['id' => $id ?? null])
        @break

    @case('radio_list')
        @include('components.form.radio_list', ['id' => $id ?? null])
        @break

    @case('checkbox')
        @include('components.form.checkbox', ['id' => $id ?? null])
        @break

    @default
        @include('components.form.input', ['id' => $id ?? null])
        @break
@endswitch
