@extends('foundation::layout.app.show')

@section('title', $company->getName())

@section('toolbar')
    @button(__('company::company.show.return')."|href:".route('company.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('enterprise::company._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('enterprise::company._html')
@endsection
