@extends('layouts.app')

@section('id', 'enterprise-membership-request-create')

@section('title')
    @component('components.panel')
        <h1>{{ __('addworking.enterprise.membership_request.create.associate_user_with_company') }} {{ $enterprise->views->link }}</h1>
    @endcomponent
@endsection

@section('content')
    <form action="{{ route('enterprise.membership_request.store', $enterprise) }}" method="POST">
        @csrf

        @component('components.panel')
            {{ enterprise_membership_request([])->views->form(@compact('enterprise')) }}
        @endcomponent

        @component('components.panel', ['pull' => "right"])
            <button class="btn btn-success">
                <i class="mr-2 fa fa-check"></i> {{ __('addworking.enterprise.membership_request.create.create_association') }}
            </button>
        @endcomponent
    </form>
@endsection
