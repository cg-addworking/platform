@inject('invoiceParameterRepository', 'Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository')

@extends('foundation::layout.app.index')

@section('title', __('enterprise.invoiceParameter.application.views.index.title')." {$enterprise->name}")

@section('toolbar')
    @can('create', [get_class($invoiceParameterRepository->make()), $enterprise])
        @button(__('enterprise.invoiceParameter.application.views.index.create')."|href:". route('addworking.enterprise.parameter.create', $enterprise)."|icon:plus|color:outline-success|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('invoice_parameter::_breadcrumb', ['page' => "index"])
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
    <col width="15%">
    <col width="15%">
    <col width="15%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @include('invoice_parameter::_table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $invoiceParameter)
        @include('invoice_parameter::_table_row')
    @empty
        <div class="text-center">
            <span>{{ __('enterprise.invoiceParameter.application.views.index.text') }} <b>{{ $enterprise->name }}</b> {{ __('enterprise.invoiceParameter.application.views.index.text_2') }}</span>
        </div>
    @endforelse
@endsection

