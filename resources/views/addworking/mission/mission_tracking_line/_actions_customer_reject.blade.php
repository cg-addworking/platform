<a class="dropdown-item" href="#" data-toggle="modal" data-target="#reject-line-customer-{{ $mission_tracking_line->id }}">
    @icon('check|color:danger|mr:3') {{ __('addworking.mission.mission_tracking_line._actions.customer_refusal') }}
</a>

@push('modals')
    @include('addworking.mission.mission_tracking_line._reject', ['is_vendor' => false])
@endpush
