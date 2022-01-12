@slot('logo')
    <img src="{{ asset('img/social/logo_addworking.png') }}" width="90px" class="mt-0">
@endslot

@component('bootstrap::components.navbar.item', ['class' => "position-relative mr-3 mb-0"])
    @icon('bell|class:fa-lg text-light')
    @badge('2|class:badge-pill position-br|color:success')

    @slot('dropdown')
        @component('bootstrap::components.navbar.dropdown.item')
            {{ __('layouts.dashboard._navbar.cps2_awaiting_sign') }}
        @endcomponent

        @include('bootstrap::components.navbar.dropdown.divider')

        @component('bootstrap::components.navbar.dropdown.item', ['href' => "#logout"])
            {{ __('layouts.dashboard._navbar.bussiness_activities') }}
        @endcomponent
    @endslot
@endcomponent

@component('bootstrap::components.navbar.item', ['class' => "position-relative mr-3"])
    @icon('envelope|class:fa-lg text-light')@badge('bla|label:2|class:badge-pill position-br|color:danger')

    @slot('dropdown')
        @component('bootstrap::components.navbar.dropdown.item')
            {{ __('layouts.dashboard._navbar.addworking') }}
        @endcomponent

        @include('bootstrap::components.navbar.dropdown.divider')

        @component('bootstrap::components.navbar.dropdown.item', ['href' => "#logout"])
            {{ __('layouts.dashboard._navbar.sogetrel') }}
        @endcomponent
    @endslot
@endcomponent

@component('bootstrap::components.navbar.item')
    {{ __('layouts.dashboard._navbar.hello') }} <b>Mr. Benjamin DELESPIERRE</b> @icon('user|class:fa-lg text-light')

    @slot('dropdown')
        @component('bootstrap::components.navbar.dropdown.item')
            @icon('cog') {{ __('layouts.dashboard._navbar.my_settings') }}
        @endcomponent

        @include('bootstrap::components.navbar.dropdown.divider')

        @component('bootstrap::components.navbar.dropdown.item', ['href' => "#logout", 'class' => "text-danger"])
            @icon('sign-out-alt') {{ __('layouts.dashboard._navbar.logout') }}
        @endcomponent
    @endslot
@endcomponent
