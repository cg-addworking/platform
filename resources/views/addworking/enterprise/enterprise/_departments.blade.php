@php
    $departments = $enterprise->departments->pluck('display_name', 'insee_code')->sort()->toArray();
@endphp

@if (count($enterprise->departments) <= 3)
    {{ implode(',', $departments) }}
@else
    <a tabindex="0" data-toggle="popover" data-trigger="focus" title="Départements" data-content="{{ implode(', ', $departments) }}">
        {{ count($enterprise->departments) }} départements
    </a>
@endif