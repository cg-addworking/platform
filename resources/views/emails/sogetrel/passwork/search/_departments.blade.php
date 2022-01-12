@php
    $departments = $passwork->departments->pluck('display_name')->sort()->toArray();
@endphp
@if (count($passwork->departments) <= 3)
    {{ implode(',', $departments) }}
@else
    {{ count($passwork->departments) }} {{ __('emails.sogetrel.passwork.search._departments.departments') }}
@endif
