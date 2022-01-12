@extends('foundation::layout.app.index')

@section('title', __('components.contract.contract.application.views.contract.accounting_monitoring.index.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.accounting_monitoring.index.return')."|href:".route('contract.index')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('contract::accounting_monitoring._breadcrumb')
@endsection

@section('form')
    @include('contract::accounting_monitoring._filters')
@endsection

@section('table.head')
    @include('contract::accounting_monitoring._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $contract)
        @include('contract::accounting_monitoring._table_row')
    @endforeach
@endsection
