@if (View::hasSection('breadcrumb'))
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light">
        @yield('breadcrumb')
    </ol>
</nav>
@endif
