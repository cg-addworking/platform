@switch($offer->status)
    @case(mission_offer()::STATUS_DRAFT)
        <span class="badge badge-pill badge-secondary">{{ __('addworking.mission.offer._status.rough_draft') }}</span>
        @break
    @case(mission_offer()::STATUS_TO_PROVIDE)
        <span class="badge badge-pill badge-warning">{{ __('addworking.mission.offer._status.diffuse') }}</span>
        @break
    @case(mission_offer()::STATUS_COMMUNICATED)
        <span class="badge badge-pill badge-success">{{ __('addworking.mission.offer._status.broadcast') }}</span>
        @break
    @case(mission_offer()::STATUS_CLOSED)
        <span class="badge badge-pill badge-secondary">{{ __('addworking.mission.offer._status.closed') }}</span>
        @break
    @case(mission_offer()::STATUS_ABANDONED)
        <span class="badge badge-pill badge-danger">{{ __('addworking.mission.offer._status.abondend') }}</span>
        @break
@endswitch
