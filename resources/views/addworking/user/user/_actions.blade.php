@component('foundation::layout.app._actions', ['model' => $user])
    @can('impersonate', $user)
        <a class="dropdown-item" href="{{ route('impersonate', $user->id) }}">
            <i class="text-success mr-3 fa fa-fw fa-magic"></i> <span class="text-success">{{ __('addworking.user.onboarding_process._actions.to_log_in') }}</span>
        </a>
    @endcan

    @support
        @if(in_array('sogetrel-soconnext', $user->tagSlugs()))
            <a class="dropdown-item" href="{{ route('user.remove_tag_soconnext', $user) }}">
                <i class="text-info mr-3 fa fa-fw fa-shield-alt"></i>
                <span class="text-info">{{ __('addworking.user.onboarding_process._actions.remove_context_tag') }}</span>
            </a>
        @else
            <a class="dropdown-item" href="{{ route('user.add_tag_soconnext', $user) }}">
                <i class="text-info mr-3 fa fa-fw fa-shield-alt"> </i>
                <span class="text-info">{{ __('addworking.user.onboarding_process._actions.add_context_tag') }}</span>
            </a>
        @endif
    @endsupport

    @can('activate', $user)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.user.onboarding_process._actions.confirm_activation') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('user-check|color:success|mr:3') <span class="text-success">@lang('messages.user.reactivate')</span>
        </a>

        @push('modals')
            <form name="{{ $name }}" action="{{ route('user.activate', $user) }}" method="POST">
                @method('PATCH')
                @csrf
            </form>
        @endpush
    @endcan

    @can('deactivate', $user)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.user.onboarding_process._actions.confirm_deactivation') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('user-times|color:danger|mr:3') <span class="text-danger">@lang('messages.user.deactivate')</span>
        </a>

        @push('modals')
            <form name="{{ $name }}" action="{{ route('user.deactivate', $user) }}" method="POST">
                @method('PATCH')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
