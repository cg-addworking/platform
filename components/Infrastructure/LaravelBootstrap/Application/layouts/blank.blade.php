<!DOCTYPE html>
<html lang="{{ $locale = app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description ?? "" }}">
    <meta name="keywords" content="{{ $keywords ?? "" }}">
    <title>{{ config('app.name', 'Laravel') }} @isset($title)| {{ $title }}@endif</title>
    <link rel="shortcut icon" href="{{ asset(config('app.icon', "")) }}" type="{{ config('app.icon_type', "image/x-icon") }}">
    <link rel="stylesheet" href="{{ asset('vendor/addworking/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/addworking/bootstrap/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/addworking/bootstrap/bootstrap-select.min.css') }}">
    @stack('stylesheets')
</head>
<body>
    @yield('page')
    @stack('modals')
    @stack('forms')
    <script src="{{ asset('vendor/addworking/bootstrap/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/addworking/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/addworking/bootstrap/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset(sprintf('vendor/addworking/bootstrap/bootstrap-select-i18n/defaults-%s_%s.min.js', $locale, $locale == 'en' ? 'US' : strtoupper($locale))) }}"></script>
    @stack('scripts')
</body>
</html>