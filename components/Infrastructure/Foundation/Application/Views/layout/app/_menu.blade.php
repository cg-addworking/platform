@inject('sectorRepository', 'Components\Mission\Offer\Application\Repositories\SectorRepository')

@auth
    @switch(true)
        @case(auth()->user()->isSupport())
            @include('foundation::layout.app._menu_support')
        @break

        @case(auth()->user()->enterprise->is_customer && auth()->user()->enterprise->is_vendor)
            @include('foundation::layout.app._menu_customer_and_vendor')
        @break

        @case(auth()->user()->enterprise->is_customer)
            @if(app()->environment('demo'))
                @include('foundation::layout.app._menu_customer_v2')
            @else
                @include('foundation::layout.app._menu_customer')
            @endif
        @break

        @case(auth()->user()->enterprise->is_vendor)
            @include('foundation::layout.app._menu_vendor')
        @break
    @endswitch
@endauth
