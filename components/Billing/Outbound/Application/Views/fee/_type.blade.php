@switch($fee->getType())
    @case('default_management_fees')
        <span class="badge badge-pill badge-success">{{ __('billing.outbound.application.views.fee._type.default_management_fees') }}</span>
        @break
    
    @case('custom_management_fees')
        <span class="badge badge-pill badge-danger">{{ __('billing.outbound.application.views.fee._type.custom_management_fees') }}</span>
        @break

    @case('subscription')
        <span class="badge badge-pill badge-warning">{{ __('billing.outbound.application.views.fee._type.subscription') }}</span>
        @break

    @case('fixed_fees')
        <span class="badge badge-pill badge-primary">{{ __('billing.outbound.application.views.fee._type.fixed_fees') }}</span>
        @break

    @case('discount')
        <span class="badge badge-pill badge-secondary">{{ __('billing.outbound.application.views.fee._type.discount') }}</span>
    @break

    @case('other')
        <span class="badge badge-pill badge-secondary">{{ __('billing.outbound.application.views.fee._type.other') }}</span>
        @break
@endswitch