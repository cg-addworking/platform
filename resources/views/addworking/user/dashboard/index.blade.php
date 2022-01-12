@extends('foundation::layout.app')

@section('main')
    @include('addworking.user.dashboard._onboarding')

    @includeWhen(auth()->user()->enterprise->is_vendor, 'addworking.user.dashboard._vendor')

    @if(auth()->user()->enterprise->is_customer)
        @if(app()->environment('demo'))
            @include('addworking.user.dashboard._customer_v2')
        @else
            @include('addworking.user.dashboard._customer')
        @endif
    @endif
@endsection

@push('stylesheets')
    <style>
        .dashboard-card {
            font-size: 175%;
        }

        .dashboard-card h5 {
            font-size: 250%;
        }

        a.dashboard-card:hover {
            text-decoration: none;
        }

        .card-group .dashboard-card:nth-child(1) {
            opacity: 1;
        }

        .card-group .dashboard-card:nth-child(1) * {
            opacity: 1;
        }

        .card-group .dashboard-card:nth-child(2) {
            opacity: .9;
        }

        .card-group .dashboard-card:nth-child(2) * {
            opacity: 1;
        }

        .card-group .dashboard-card:nth-child(3) {
            opacity: .8;
        }

        .card-group .dashboard-card:nth-child(3) * {
            opacity: 1;
        }

        .card-group .dashboard-card:nth-child(4) {
            opacity: .7;
        }

        .card-group .dashboard-card:nth-child(4) * {
            opacity: 1;
        }
    </style>
@endpush
