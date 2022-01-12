@switch($type ?? "text")
    @case('checkbox')
        @include('bootstrap::form.control.checkbox')
        @break

    @case('checkbox_list')
        @include('bootstrap::form.control.checkbox_list')
        @break

    @case('color')
    @case('date')
    @case('datetime-local')
    @case('email')
    @case('file')
    @case('month')
    @case('number')
    @case('password')
    @case('range')
    @case('search')
    @case('tel')
    @case('text')
    @case('time')
    @case('url')
    @case('week')
        @include('bootstrap::form.control.input')
        @break

    @case('radio')
        @include('bootstrap::form.control.radio')
        @break

    @case('radio_list')
        @include('bootstrap::form.control.radio_list')
        @break

    @case('select')
        @include('bootstrap::form.control.select')
        @break

    @case('switch')
        @include('bootstrap::form.control.switch')
        @break

    @case('textarea')
        @include('bootstrap::form.control.textarea')
        @break
@endswitch
