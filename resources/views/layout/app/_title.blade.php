<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2" style="flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="@yield('title')">
        @yield('title', __('layout.app._title.untitled_page'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @yield('toolbar')
    </div>
</div>
