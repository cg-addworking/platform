<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Addworking') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo_square.png') }}" type="image/png" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @include('_gtm_datalayer')
    @include('_gtm_head')
</head>
<body>
    @include('_gtm_body')
    <div id="@yield('id', 'app')" class="page-wrapper @yield('page-class') toggled">
        <div class="sidebar-wrapper">
            @if (Auth::check())
                <nav class="navbar navbar-inverse sidebar-menu">
                    @include('layouts._menu')
                </nav>
            @endif
        </div>

        <div class="content-wrapper">
            @include('_navbar')

            <div class="@yield('container-class', 'container-fluid')">
                @include('layouts._status')

                <div class="page-title">
                    @yield('title')
                </div>

                <div class="page-content">
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="text-center py-3">
            © {{date('Y') }} Copyright: <a href="https://www.addworking.com/"> AddWorking</a>
        </footer>
    </div>

    @stack('modals')

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')

    @stack('scripts-stack')
</body>
</html>
