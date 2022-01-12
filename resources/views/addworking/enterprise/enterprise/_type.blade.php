@if ($enterprise->isVendor())
    <span class="badge badge-pill badge-success">{{ __('addworking.enterprise.enterprise._type.service_provider') }}</span>
@endif

@if ($enterprise->isCustomer())
    <span class="badge badge-pill badge-warning">{{ __('addworking.enterprise.enterprise._type.customer') }}</span>
@endif
