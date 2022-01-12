@forelse ($user->enterprises as $enterprise)
    {{ $enterprise->views->link }} @if ($enterprise->pivot->job_title) ({{ $enterprise->pivot->job_title }}) @endif
    @unless ($loop->last)
        <br>
    @endif
@empty
    n/a
@endforelse
