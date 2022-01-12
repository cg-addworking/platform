<li>
    <a href="{{ route('user.index') }}">
        <i class="fa fa-fw fa-users"></i> {{ __('layouts.menu.admin.users') }}
    </a>
</li>

<li>
    <a href="{{ route('support.user.onboarding_process.index') }}">
        <i class="fa fa-fw fa-step-forward"></i> {{ __('layouts.menu.admin.onboarding_process') }}
    </a>
</li>

<li>
    <a href="{{ route('enterprise.index') }}">
        <i class="fa fa-fw fa-building-o"></i> {{ __('layouts.menu.admin.enterprise') }}
    </a>
</li>

@include('layouts.menu.mission')

@can('index', sogetrel_passwork())
    <li>
        <a href="{{ route('sogetrel.passwork.index') }}">
            <i class="fa fa-fw fa-list-alt"></i> {{ __('layouts.menu.admin.passwork') }}
        </a>
    </li>
@endcan
