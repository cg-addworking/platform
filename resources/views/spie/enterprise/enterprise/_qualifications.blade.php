@php
    $qualifications = $enterprise->qualifications
        ->sortBy('display_name')
        ->pluck('display_name')
        ->map(function ($activity) { return ucfirst(strtolower($activity)); })
        ->join('<br>')
@endphp

@if (count($enterprise->qualifications) > 3)
    <a style="cursor: pointer" tabindex="0" role="button" data-toggle="popover" title="Qualifications" data-content="{{ $qualifications }}" data-html="true">{{ count($enterprise->qualifications) }} qualifications</a>
@elseif (count($enterprise->qualifications) == 0)
    <small class="text-muted">n/a</small>
@else
    {!! $qualifications !!}
@endif
