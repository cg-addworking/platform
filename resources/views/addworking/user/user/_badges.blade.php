@if ($user->enterprise->isVendor())
    <span class="badge badge-pill badge-success">{{ __('addworking.user.user._badges.service_provider') }}</span>
@endif

@if ($user->enterprise->isCustomer())
    <span class="badge badge-pill badge-warning">{{ __('addworking.user.user._badges.client') }}</span>
@endif

@if ($user->isSupport())
    <span class="badge badge-pill badge-danger">{{ __('addworking.user.user._badges.support') }}</span>
@endif
