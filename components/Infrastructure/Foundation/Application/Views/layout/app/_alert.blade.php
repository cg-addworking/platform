@if (View::hasSection('alert'))
    <nav aria-label="alert" class="alert alert-info">
        @yield('alert')
    </nav>
@endif
