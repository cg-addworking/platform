@php
    $coverage_zones = $enterprise->coverageZones
        ->sortBy('department.name')
        ->pluck('department.name')
        ->join('<br>');
@endphp

@if (count($enterprise->coverageZones) > 3)
    <a style="cursor: pointer" tabindex="0" role="button" data-toggle="popover" title="Zones d'intervention" data-content="<div style='max-heigh: 250px'>{{ $coverage_zones }}</div>" data-html="true">{{ count($enterprise->coverageZones) }} départements</a>
@elseif (count($enterprise->coverageZones) == 0)
    <small class="text-muted">n/a</small>
@else
    {!! $coverage_zones !!}
@endif
