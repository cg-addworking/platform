@extends('foundation::layout.app.show', ['action' => $contract->routes->create])

@section('title', __('addworking.contract.contract.create.create_contract'))

@section('toolbar')
    @button(__('addworking.contract.contract.create.return')."|href:{$contract->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('content')
    <div class="row">
        @can('createFromExistingFile', [App\Models\Addworking\Contract\Contract::class, $contract->enterprise])
            <div class="col-md-3">
                <a class="btn btn-primary p-5 btn-block" href="{{ $contract->routes->createFromExistingFile }}">
                    @icon('file-signature') {{ __('addworking.contract.contract.create.create_from_existing_file') }}
                </a>
            </div>
        @endcan

        @can('createFromExistingFile', [App\Models\Addworking\Contract\Contract::class, $contract->enterprise])
            <div class="col-md-3">
                <a class="btn btn-secondary p-5 btn-block" href="{{ $contract->routes->createBlank }}">
                    @icon('feather-alt') {{ __('addworking.contract.contract.create.create_blank_contract') }}
                </a>
            </div>
        @endcan
    </div>


    {{--
    @can('createFromTemplate', [App\Models\Addworking\Contract\Contract::class, $contract->enterprise])
        <a class="btn btn-secondary" href="{{ $contract->routes->createFromTemplate }}">
            {{ __('addworking.contract.contract.create.create_from_mockup') }}
        </a>
    @endcan
    --}}
@endsection
