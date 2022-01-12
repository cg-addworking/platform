@extends('foundation::layout.app.create', [
    'action' => route('sogetrel.passwork.status', $passwork),
    'enctype' => "multipart/form-data",
    'method' => "PUT"
])

@section('title', __('sogetrel_passwork::acceptation.create.title'))

@section('toolbar')
    @button(__('sogetrel_passwork::acceptation.create.return')."|href:".route('contract.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('sogetrel_passwork::acceptation._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('sogetrel_passwork::acceptation._form', ['page' => 'create'])

    <div class="offset-2 mt-3 pl-3">
        <button type="submit" class="btn btn-success shadow">
            @icon('check') {{__('sogetrel_passwork::acceptation.create.create')}}
        </button>
    </div>
@endsection
