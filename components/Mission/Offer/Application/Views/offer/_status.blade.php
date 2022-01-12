@switch($offer->getStatus())
    @case($offer::STATUS_DRAFT)
        <span class="badge badge-pill badge-secondary">{{ __('offer::offer._status.draft') }}</span>
    @break
    @case($offer::STATUS_TO_PROVIDE)
        <span class="badge badge-pill badge-warning">{{ __('offer::offer._status.to_provide') }}</span>
    @break
    @case($offer::STATUS_COMMUNICATED)
        <span class="badge badge-pill badge-success">{{ __('offer::offer._status.communicated') }}</span>
    @break
    @case($offer::STATUS_CLOSED)
        <span class="badge badge-pill badge-secondary">{{ __('offer::offer._status.closed') }}</span>
    @break
    @case($offer::STATUS_ABANDONED)
        <span class="badge badge-pill badge-danger">{{ __('offer::offer._status.abandoned') }}</span>
    @break
@endswitch
