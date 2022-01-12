<nav class="navbar navbar-expand-lg navbar-dark border-bottom mb-2 border-bottom-0 @if(!empty($_no_background)) @elseif(app()->environment('production', 'demo')) bg-primary @elseif(app()->environment('review', 'staging')) bg-warning @else bg-success @endif">
    @if (empty($_no_sidebar))
        <button class="btn @if(app()->environment('production', 'demo')) btn-primary @elseif(app()->environment('review', 'staging')) btn-warning @else btn-success @endif" id="menu-toggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-user"></i>
        </button>
    @else
        <div style="color: white">{{ config('app.name') }}</div>
    @endif
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @unless(app()->environment('production'))
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="navbar-text pl-3 text-uppercase">
                        {{ app()->environment() }}
                    </span>
                </li>
            </ul>
        @endunless
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{Config::get('app.locale', []) === 'de' ? "https://intercom.help/addworking/de/" : "https://intercom.help/addworking/fr/"}}" target="_blank">@icon('question|ml:0|mr:1') {{ __('messages.help') }} </a>
            </li>
            @if (auth::check() && (auth::user()->isSupport() || auth()->user()->enterprise->isCustomer() || auth()->user()->enterprise->isVendor()))
                @if (count(Config::get('app.available_locales', [])) > 1)
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="tre" aria-expanded="false">
                            @icon('language|ml:2|mr:1') {{ __('messages.change_locale') }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach(Config::get('app.available_locales', []) as $locale)
                                <a href="?locale={{ $locale }}" class="dropdown-item">
                                    {{ __("messages.locale.{$locale}") }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                @endif
            @endif
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">@lang('user.login.title')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">@lang('user.register.title')</a>
                </li>
            @else
                @impersonating
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('impersonate.leave') }}">
                        @icon('user-secret|ml:2|mr:1') {{ trans('foundation::menu_support.back_to_admin') }}
                    </a>
                </li>
                @endImpersonating
                @if(app()->environment('local') && !auth()->user()->isConfirmed())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('confirmation.force') }}">
                            @icon('user-check|ml:2|mr:1') {{ trans('foundation::menu_support.confirmation') }}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->enterprises()->count() > 1)
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="tre" aria-expanded="false">
                            @icon('building|ml:2|mr:1') {{ auth()->user()->enterprise->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-user-dropdown">
                            @foreach(auth()->user()->enterprises()->orderBy('name')->get() as $enterprise)
                                @can('swapEnterprise', [auth()->user(), $enterprise])
                                    <a href="{{ route('addworking.user.user.swap_enterprise', [auth()->user(), $enterprise]) }}" class="dropdown-item">
                                        {{ $enterprise->name }}
                                    </a>
                                @endcan
                            @endforeach
                        </div>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-user-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('user|ml:2|mr:1') {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-user-dropdown">
                        <a class="dropdown-item" href="{{ route('profile') }}">@icon('user|mr:2|color:muted') @lang('profile.profile.title')</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" onclick="document.forms['{{ $name = uniqid('form_') }}'].submit()">@icon('sign-out-alt|mr:2') @lang('user.login.logout')</a>
                        <form style="display:none" name="{{ $name }}" action="{{ route('logout') }}" method="POST">@csrf</form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
