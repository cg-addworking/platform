@extends('addworking.user.auth.login')

@section('content')
    @parent

    @component('components.modal', ['id' => "sogetrel-soconnext-moins-15-salaries"])
        @slot('title')
            {{ __('sogetrel.user.login.welcome_title') }}
        @endslot

        <img src="{{ asset('img/logo_sogetrel.png') }}" class="d-block m-auto" style="max-width: 250px; max-height: 200px">
        <img src="{{ asset('img/logo_soconnext.png') }}" class="d-block m-auto" style="max-width: 250px; max-height: 200px">

        <p class="mt-4">
            {{ __('sogetrel.user.login.welcome_description1') }}
            {{ __('sogetrel.user.login.welcome_description2') }}
            {{ __('sogetrel.user.login.welcome_description3') }}
            {{ __('sogetrel.user.login.welcome_description4') }}
        </p>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="btn btn-lg btn-success">
                <i class="mr-2 fa fa-thumbs-o-up"></i> {{ __('sogetrel.user.login.registering') }}
            </a>
        </div>
    @endcomponent
@endsection

@push('scripts')
    <script>
        $('#sogetrel-soconnext-moins-15-salaries').modal({ show: true })
    </script>
@endpush
