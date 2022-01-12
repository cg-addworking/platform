@extends('foundation::layout.app')

@section('main')
    @include('foundation::layout.app._title')
    @include('foundation::layout.app._breadcrumb')
    @include('foundation::layout.app._alert')

    @if (View::hasSection('tabs'))
        <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                @yield('tabs')
            </div>
        </nav>
    @endif

    <div class="tab-content" id="nav-tabContent">
        @yield('content')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            const key = `tab:/${window.location.pathname}`;

            let tabs = $('nav .nav-tabs a.nav-item[href]').click(function(event) {
                window.location.hash = this.getAttribute('id');
                localStorage.setItem(key, this.getAttribute('id'));
            });

            if (window.location.hash) {
                tabs.filter(window.location.hash).click();
            } else if (localStorage.getItem(key)) {
                tabs.filter(`#${localStorage.getItem(key)}`).click();
            } else {
                tabs.filter('.active').click();
            }
        });
    </script>
@endpush
