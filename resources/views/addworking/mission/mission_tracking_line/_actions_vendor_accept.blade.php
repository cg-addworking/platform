<a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.mission.mission_tracking_line._actions.accept_mission') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
    @icon('check|color:success|mr:3') {{ __('addworking.mission.mission_tracking_line._actions.provider_validation') }}
</a>

@push('modals')
    <form name="{{ $name }}" action="{{ $mission_tracking_line->routes->validation }}" method="POST">
        @csrf
        <input type="hidden" name="line[validation_vendor]" value="{{ $mission_tracking_line::STATUS_VALIDATED }}">
    </form>
@endpush
