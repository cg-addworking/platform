@php
    $departments = $passwork->departments->pluck('display_name')->sort()->toArray();
@endphp

@if (count($passwork->departments) <= 3)
    {{ implode(',', $departments) }}
@else
    <a tabindex="0" data-toggle="popover" data-trigger="focus" title="Départements" data-content="{{ implode(', ', $departments) }}">
        {{ count($passwork->departments) }} {{ __('sogetrel.user.passwork._departments.departments') }}
    </a>
@endif
