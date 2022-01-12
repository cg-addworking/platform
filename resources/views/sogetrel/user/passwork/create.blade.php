@extends('layouts.app')

@section('id', 'sogetrel-user-passwork-create')

@section('title')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="m-0">{{ __('sogetrel.user.passwork.create.passwork_sogetrel') }}</h1>
            @endcomponent
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                @include('_form_errors')

                <form class="form" method="post" enctype="multipart/form-data" action="{{ route('sogetrel.passwork.store') }}" novalidate>
                    {{ csrf_field() }}

                    {{ $passwork->views->form }}
                </form>
            @endcomponent
        </div>
    </div>

@endsection
