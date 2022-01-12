@component('foundation::layout.app._actions', ['model' => $mission_tracking_line])
    @can('validationCustomer', $mission_tracking_line)
        {{ $mission_tracking_line->views->actions_customer_accept }}
        {{ $mission_tracking_line->views->actions_customer_reject }}
    @endcan

    @can('validationVendor', $mission_tracking_line)
        {{ $mission_tracking_line->views->actions_vendor_accept }}
        {{ $mission_tracking_line->views->actions_vendor_reject }}
    @endcan
@endcomponent
