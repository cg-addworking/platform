@extends('bootstrap::layouts.dashboard')

@section('page.main.header')
    <h1>@icon("plus|class:text-primary") {{ __('layouts.dashboard.create.add_user') }}</h1>
    <hr>
    @component('bootstrap::components.anchor', ['href' => "#"])
        @icon('arrow-left') {{ __('layouts.dashboard.create.go_back_to_previous_page') }}
    @endcomponent
@endsection

@section('page.main.footer')
    <span class="text-sm text-center font-weight-bold">&copy; Addworking 2019</span>
@endsection
