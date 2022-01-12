@php
    $activities = $enterprise->enterprise->activities
        ->sortBy('activity')
        ->pluck('activity')
        ->map(function ($activity) { return ucfirst(strtolower($activity)); })
        ->join('<br>');
@endphp

@if (count($enterprise->enterprise->activities) > 1)
    <a style="cursor: pointer" tabindex="0" role="button" data-toggle="popover" title="Activités" data-content="{{ $activities }}" data-html="true">{{ count($enterprise->enterprise->activities) }} activités</a>
@elseif (count($enterprise->enterprise->activities) == 0)
    <small class="text-muted">n/a</small>
@else
    {!! $activities !!}
@endif
