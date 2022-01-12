@switch($mission->getStatus())
    @case($mission::STATUS_DRAFT)
        <span class="badge badge-pill badge-secondary">{{ __('mission::mission._status.draft') }}</span>
    @break
    @case($mission::STATUS_READY_TO_START)
        <span class="badge badge-pill badge-info">{{ __('mission::mission._status.ready_to_start') }}</span>
    @break
    @case($mission::STATUS_IN_PROGRESS)
        <span class="badge badge-pill badge-primary">{{ __('mission::mission._status.in_progress') }}</span>
    @break
    @case($mission::STATUS_DONE)
        <span class="badge badge-pill badge-success">{{ __('mission::mission._status.done') }}</span>
    @break
    @case($mission::STATUS_CLOSED)
        <span class="badge badge-pill badge-danger">{{ __('mission::mission._status.closed') }}</span>
    @break
    @case($mission::STATUS_ABANDONED)
        <span class="badge badge-pill badge-warning">{{ __('mission::mission._status.abandoned') }}</span>
    @break
    @default
        <span class="badge badge-pill badge-secondary">{{ $mission->getStatus() }}</span>
    @break
@endswitch
