@php
    $departments = $item->departments->pluck('display_name')->sort()->toArray();
@endphp

@if (count($item->departments) <= 3)
    {{ implode(',', $departments) }}
@else
    <a href="#" data-toggle="popover" data-placement="right" data-trigger="focus" title="Départements" data-content="{{ implode(', ', $departments) }}">
        {{ count($item->departments) }} {{ __('addworking.mission.mission._departments.departments') }} 
    </a>
@endif