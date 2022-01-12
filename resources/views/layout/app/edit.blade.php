@extends('foundation::layout.app')

@section('main')
    @include('foundation::layout.app._title')
    @include('foundation::layout.app._breadcrumb')

    @component('bootstrap::form', ['action' => $action, 'method' => $method ?? "put", 'enctype' => $enctype ?? "application/x-www-form-urlencoded"])
        @yield('form')
    @endcomponent
@endsection
