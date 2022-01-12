@extends('foundation::layout.app', ['_no_background' => true, '_no_shadow' => true, '_no_sidebar' => true, '_no_message' => true])

@section('main')
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
            <div class="card mt-5 shadow">
                <div class="card-body">
                    <h5 class="card-title">@yield('title')</h5>
                    <hr>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    <style>
        body {
            background: #007bff;
        }

        main footer {
            color: white;
        }

        main footer a {
            color: inherit;
        }
    </style>
@endpush
