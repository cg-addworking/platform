@if ($enterprise->isVendor())
    <span class="badge badge-pill badge-success">{{ __('addworking.enterprise.enterprise._badges.service_provider') }}</span>
@endif

@if ($enterprise->isCustomer())
    <span class="badge badge-pill badge-warning">{{ __('addworking.enterprise.enterprise._badges.client') }}</span>
@endif
