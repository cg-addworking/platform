@switch($tracking->status)
    @case(mission_tracking()::STATUS_PENDING)
    <span class="badge badge-pill badge-secondary">{{ __('addworking.mission.mission_tracking._status.waiting') }}</span>
    @break

    @case(mission_tracking()::STATUS_VALIDATED)
    <span class="badge badge-pill badge-success">{{ __('addworking.mission.mission_tracking._status.valid') }}</span>
    @break

    @case(mission_tracking()::STATUS_REFUSED)
    <span class="badge badge-pill badge-danger">{{ __('addworking.mission.mission_tracking._status.refuse') }}</span>
    @break

    @case(mission_tracking()::STATUS_SEARCH_FOR_AGREEMENT)
        <span class="badge badge-pill badge-warning">{{ __('addworking.mission.mission_tracking._status.search_for_agreement') }}</span>
    @break
@endswitch
