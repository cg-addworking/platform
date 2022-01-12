<html>
    <head>
    <style>
        @page {
            margin: 100px 25px;
        }

        body {
            font-family: Helvetica, sans-serif;
            font-size: 10px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            background-color: blue;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 40px;
            page-break-before: avoid;
        }

        footer .pagenum:before {
            content: counter(page);
        }

        div.page {
            page-break-after: always;
        }

        div.page:last-child {
            page-break-after: never;
        }

        table.footer {
            width: 100%;
            border-collapse: collapse;
        }

        table.footer td.first,
        table.footer td.last {
            width: 65px;
            vertical-align: bottom;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .strong {
            font-size: 14px;
            color: #1da5cd;
        }

        .small {
            font-size: 8px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <header>
        @yield('header')
    </header>

    <footer>
        @section('footer')
            <table class="footer">
                <tr>
                    <td class="first">&nbsp;</td>
                    <td class="text-center"><b>{{ __('layouts.document.addworking') }}</b><br><span style="small">{{ __('layouts.document.text_line1') }} </span></td>
                    <td class="text-right last">
                        Page <span class="pagenum"></span>
                    </td>
                </tr>
            </table>
        @show
    </footer>

    <main>
        @yield('content')
    </main>
</body>
</html>
