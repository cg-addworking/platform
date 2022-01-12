@extends('bootstrap::layouts.dashboard')

@section('page.main.header')
    <div class="row justify-content-between">
        <div class="col-md-8">
            <h1>@icon('user|class:text-primary') {{ __('layouts.dashboard.show.miss_lucy') }} @icon('link|class:text-primary')</h1>
        </div>
        <div class="col-md-4">
            @component('bootstrap::components.anchor', [
                'class' => "btn btn-outline-warning font-weight-bold float-right rounded mt-2",
                'data-toggle' => "modal",
                'type' => 'button',
                'data-target' => "#exampleModalLong"
            ])
                @icon('edit|class:mr-1') {{ __('layouts.dashboard.show.edit') }}
            @endcomponent
        </div>
    </div>
    <hr>
    @component('bootstrap::components.anchor', ['href' => "#"])
        @icon('arrow-left') {{ __('layouts.dashboard.show.go_back_to_previous_page') }}
    @endcomponent
@endsection


@section('page.main.footer')
    <span class="text-sm text-center font-weight-bold">&copy; Addworking 2019</span>
@endsection
