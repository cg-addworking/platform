@extends('bootstrap::layouts.dashboard')

@section('page.main.header')
    <div class="row justify-content-between">
        <div class="col-md-8">
            <h1>@icon('users|class:text-primary') {{ __('layouts.dashboard.index.users') }} <span class="text-muted">(3)</span></h1>
        </div>
        <div class="col-md-4">
            <div class="input-group mb-3">
                @input('Rechercher...|type:text|class:form-control')
                <div class="input-group-append">
                    @component('bootstrap::components.button', [
                        'class' => "btn input-group-text rounded-right",
                        'href' => "#"
                    ])
                        @icon('search')
                    @endcomponent
                    @component('bootstrap::components.anchor', [
                        'class' => "btn btn-outline-success font-weight-bold ml-4 rounded",
                        'data-toggle' => "modal",
                        'type' => 'button',
                        'data-target' => "#exampleModalLong"
                    ])
                        @icon('plus|class:mr-1') {{ __('layouts.dashboard.index.add') }}
                    @endcomponent
                    <div class="btn-group dropdown">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-outline-dark rounded ml-3">
                            @icon('ellipsis')
                        </a>
                        <div class="dropdown-menu" style="box-shadow: 0 10px 10px #ccced1">
                            <a class="dropdown-item mb-1" href="#">@icon('eye|class:mr-1') {{ __('layouts.dashboard.index.consult') }}</a>
                            <a class="dropdown-item text-warning" href="#">@icon('edit|class:mr-1') {{ __('layouts.dashboard.index.edit') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#">@icon('trash|class mr-1') {{ __('layouts.dashboard.index.remove') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    @component('bootstrap::components.collapse')
        @slot('title')
            {{ __('layouts.dashboard.index.advance_search') }}
        @endslot

        @component('bootstrap::components.form', ['class' => "mt-3"])
            @form_orientation('horizontal')

            @label(__('layouts.dashboard.index.role'))
            @checkbox(__('layouts.dashboard.index.first_name'))
            @checkbox(__('layouts.dashboard.index.last_name'))
            @checkbox(__('layouts.dashboard.index.email'))
            @checkbox(__('layouts.dashboard.index.enterprise'))
            @checkbox(__('layouts.dashboard.index.role'))

            @slot('footer')
                @component('bootstrap::components.button')
                    @icon('search') {{ __('layouts.dashboard.index.search') }}
                @endcomponent
            @endslot
        @endcomponent
    @endcomponent
@endsection
