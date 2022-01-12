@forelse ($enterprise->activities as $activity)
    {{ $activity->activity }} ({{ $activity->field}})
    @if ($activity->employees_count)
        - {{ $activity->employees_count }} {{ __('addworking.enterprise.enterprise._activities.employee') }}
    @endif
    @unless($loop->last)
        <br>
    @endunless
@empty
    n/a
@endforelse
