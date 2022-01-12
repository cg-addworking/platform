<a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#ok-to-meet-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-handshake text-primary"></i>{{ __('addworking.mission.proposal_response._status.validate_price') }}
</a>

<a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#interview-requested-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-handshake text-primary"></i>{{ __('addworking.mission.proposal_response._status.exchange_req') }}
</a>

<a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#interview-positive-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-handshake text-primary"></i>{{ __('addworking.mission.proposal_response._status.exchange_positive') }}
</a>

<a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#final-validation-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-check text-success"></i>{{ __('addworking.mission.proposal_response._status.final_validation') }}
</a>

<a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#pending-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-clock text-warning"></i>{{ __('addworking.mission.proposal_response._status.waiting') }}
</a>

<a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#reject-proposal-response-{{ $response->id }}">
    <i class="mr-3 fa fa-fw fa-times text-danger"></i>{{ __('addworking.mission.proposal_response._status.refuse') }}
</a>

@push('modals')
    @include('addworking.mission.proposal_response.status._ok_to_meet')
    @include('addworking.mission.proposal_response.status._interview_requested')
    @include('addworking.mission.proposal_response.status._interview_positive')
    @include('addworking.mission.proposal_response.status._final_validation')
    @include('addworking.mission.proposal_response.status._pending')
    @include('addworking.mission.proposal_response.status._reject')
@endpush