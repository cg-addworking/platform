<li class="nav-item">
    <a class="nav-link active" href="{{ route('dashboard') }}">
        @icon('home|mr:2') {{ __('layout.app._menu.dashboard') }}
    </a>
</li>

@auth
    @switch(true)
        @case(auth()->user()->isSupport())
            @include('foundation::layout.app._menu_support')
        @break

        @case(auth()->user()->enterprise->is_customer && auth()->user()->enterprise->is_vendor)
            @include('foundation::layout.app._menu_customer_and_vendor')
        @break

        @case(auth()->user()->enterprise->is_customer)
            @include('foundation::layout.app._menu_customer')
        @break

        @case(auth()->user()->enterprise->is_vendor)
            @include('foundation::layout.app._menu_vendor')
        @break
    @endswitch

@endauth
