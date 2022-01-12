<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Addworking') }}</title>
    <style type="text/css">
        body {
            font-family: Helvetica, sans-serif;
            font-size: 10px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
