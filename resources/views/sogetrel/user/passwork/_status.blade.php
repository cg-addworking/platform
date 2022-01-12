@switch ($passwork->status)
    @case (sogetrel_passwork()::STATUS_ACCEPTED)
        <span class="badge badge-pill badge-success">{{ __('sogetrel.user.passwork._status.accept') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_ACCEPTED_QUEUED)
        <span class="badge badge-pill badge-success">{{ __('sogetrel.user.passwork._status.accept_queue') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_REFUSED)
        <span class="badge badge-pill badge-danger">{{ __('sogetrel.user.passwork._status.reject') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_PREQUALIFIED)
        <span class="badge badge-pill badge-primary">{{ __('sogetrel.user.passwork._status.prequalified') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_NOT_RESULTED)
        <span class="badge badge-pill badge-secondary">{{ __('sogetrel.user.passwork._status.not_resulted') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_BLACKLISTED)
        <span class="badge badge-pill badge-dark">{{ __('sogetrel.user.passwork._status.blacklisted') }}</span>
        @break

    @case (sogetrel_passwork()::STATUS_PENDING)
    @default
        <span class="badge badge-pill badge-warning">{{ __('sogetrel.user.passwork._status.pending') }}</span>
@endswitch
