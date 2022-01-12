@if (View::hasSection('breadcrumb'))
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb bg-light border">
            @yield('breadcrumb')
        </ol>
    </nav>
@endif
