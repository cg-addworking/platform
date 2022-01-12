@extends('foundation::layout.app.create', ['action' => route('sector.response.store', $offer), 'enctype' => "multipart/form-data"])

@section('title', __('offer::response.create.title', ['label' => $offer->getLabel()]))

@section('toolbar')
    @button(__('offer::response.create.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('offer::response._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('offer::response.construction._form')

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ __('offer::response.create.submit') }}</button>
    </div>
@endsection