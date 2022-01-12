<li>
    <a href="{{ route('profile.customers') }}">
        <i class="fa fa-fw fa-users"></i> {{ __('layouts.menu.vendor.my_clients') }}
    </a>
</li>

@can('index', [inbound_invoice(), Auth::user()->enterprise])
    <li>
        <a href="{{ inbound_invoice([])->enterprise()->associate(auth()->user()->enterprise)->routes->index }}">
            <i class="fa fa-fw fa-euro"></i> {{ __('layouts.menu.vendor.my_bills') }}
        </a>
    </li>
@endcan
