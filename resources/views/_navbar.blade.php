<nav class="navbar navbar-default top-menu">
    <div class="container-fluid">
        <div class="navbar-header">
            <!-- Branding Image -->
            <style type="text/css">
                @media screen and (max-width: 1100px) and (max-height: 2000px) {
                    .logo_addworking {
                        position: relative;
                        top:-10px;
                    }
                }
            </style>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="logo_addworking" src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">@lang('user.login.title')</a></li>
                    <li><a href="{{ route('register') }}">@lang('user.register.title')</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('profile') }}">@lang('profile.profile.title')</a>
                            </li>
                            <li class="separator"></li>
                            <li>
                                <a href="#" onclick="document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                    @lang('user.login.logout')
                                </a>
                                <form name="{{ $name }}" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell"></i></a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#" class="text-muted">Vos messages apparaitront ici...</a>
                            </li>
                        </ul>
                    </li>
                    @if(auth()->user()->isSupport())
                        <li>
                            <a href="https://goo.gl/forms/BMfax88siVt75zpm2" role="button" target="_blank">
                                <i class="fa fa-fw fa-bug text-danger"></i>
                            </a>
                        </li>
                    @endif

                    @impersonating
                        <li>
                            <a href="{{ route('impersonate.leave') }}">
                                <span class="text-danger"><i class="fa fa-magic mr-2"></i> Retour à l'admin</span>
                            </a>
                        </li>
                    @endImpersonating

                    @if (app()->environment('local') && !auth()->user()->isConfirmed())
                        <li>
                            <a href="{{ route('confirmation.force') }}">
                                <span class="text-success"><i class="fa fa-magic mr-2"></i> Confirmation Manuelle</span>
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
