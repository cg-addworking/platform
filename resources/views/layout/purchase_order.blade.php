<html>
<head>
    <style>
        @page {
            margin: 100px 25px;
        }

        div.page {
            page-break-after: always;
        }

        div.page:last-child {
            page-break-after: never;
        }

        body {
            font-family: Helvetica, sans-serif;
            font-size: 10px;
        }

        .clearfix:after {
            content: "";
            clear: both;
        }
        .clearfix {display: block;}
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')
</body>
</html>
