<a class="dropdown-item" href="#" data-toggle="modal" data-target="#reject-line-vendor-{{ $mission_tracking_line->id }}">
    @icon('times|color:danger|mr:3') {{ __('addworking.mission.mission_tracking_line._actions.service_provider_refusal') }}
</a>

@push('modals')
    @include('addworking.mission.mission_tracking_line._reject', ['is_vendor' => true])
@endpush
