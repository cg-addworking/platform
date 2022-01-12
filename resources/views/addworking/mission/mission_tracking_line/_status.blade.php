{{--I removed the auth()->check because the switch is always true so he stop on the first condition--}}
@switch($status)
    @case('validated')
        <span class="badge badge-pill badge-success">{{ __("mission.mission.tracking.status.".$status) }}</span>
    @break

    @case('rejected')
        <span class="badge badge-pill badge-danger">{{ __("mission.mission.tracking.status.".$status) }}</span>
    @break

    @case('pending')
        <span class="badge badge-pill badge-primary">{{ __("mission.mission.tracking.status.".$status) }}</span>
    @break
@endswitch