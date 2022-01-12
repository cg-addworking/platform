@extends('foundation::layout.app.index')

@section('title', __('addworking.components.billing.inbound.index.title'))

@section('toolbar')
    @button(__('addworking.components.billing.inbound.index.button.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button("Exporter|href:".route('inbound_invoice.export')."?".http_build_query(request()->all())."|icon:file-export|color:primary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.components.billing.inbound.index.breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.components.billing.inbound.index.breadcrumb.inbound')."|active")
@endsection

@section('form')
    @include('inbound::_count_cards')
    <hr>
    @include('inbound::_filters')
@endsection

@section('table.head')
    @include('inbound::_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $invoice)
        @include('inbound::_table_row')
    @endforeach
@endsection