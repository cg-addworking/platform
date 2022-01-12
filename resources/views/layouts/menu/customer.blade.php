@can('viewAnyVendor', auth()->user()->enterprise)
    <li>
        <a href="{{ route('addworking.enterprise.vendor.index', auth()->user()->enterprise) }}">
            <i class="fa fa-fw fa-users"></i> {{ __('layouts.menu.customer.my_providers') }}
        </a>
    </li>
@endcan

@can('index', sogetrel_passwork())
    <li>
        <a href="{{ route('sogetrel.passwork.index') }}">
            <i class="fa fa-fw fa-list-alt"></i> {{ __('layouts.menu.customer.passwork') }}
        </a>
    </li>
@endcan

@if (auth()->user()->hasAccessToBilling())
    <li>
        <a href="{{ route('addworking.billing.outbound.index', auth()->user()->enterprise) }}">
            <i class="fa fa-fw fa-files-o"></i> {{ __('layouts.menu.customer.billing') }}
        </a>
    </li>
@endif

@can('index', edenred_code())
    <li>
        <a class="dropdown-item" href="{{ route('edenred.common.code.index') }}">
            <i class="text-muted mr-3 fas fa-barcode"></i> {{ __('layouts.menu.customer.bussiness_codes') }}
        </a>
    </li>
@endcan
