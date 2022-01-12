<ul class="nav sidebar-nav">
    <li>
        <a href="{{ route('dashboard') }}">
            <i class="fa fa-fw fa-home"></i> @lang('messages.menu.dashboard')
        </a>
    </li>

    @includeWhen(auth()->user()->isSupport(), 'layouts.menu.admin')
    @includeWhen(auth()->user()->enterprise->exists, 'layouts.menu.enterprise')
    @includeWhen(auth()->user()->hasAccessToMission(), 'layouts.menu.mission')

    @includeWhen(auth()->user()->enterprise->is_customer, 'layouts.menu.customer')
    @includeWhen(auth()->user()->enterprise->is_vendor, 'layouts.menu.vendor')
</ul>
