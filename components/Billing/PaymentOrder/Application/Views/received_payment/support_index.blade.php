@inject('receivedPaymentRepository', "Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository")

@extends('foundation::layout.app.index')

@section('title', __('addworking.components.billing.outbound.received_payment.index.title_support'))

@section('toolbar')
    @can('import', get_class($receivedPaymentRepository->make()))
        @button("Importer des paiements reçus|href:".route('support.received_payment.import')."|icon:upload|color:outline-primary|outline|sm|mr:2")
    @endcan
@endsection

@section('breadcrumb')
    @include('payment_order::received_payment._breadcrumb', ['page' => "support_index"])
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="10%">
    <col width="40%">
    <col width="10%">
    <col width="15%">
    <col width="5%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @include('payment_order::received_payment._table_head')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $received_payment)
        @include('payment_order::received_payment._table_row', compact('items'))
    @empty
        <div class="text-center mb-3">
            <span>{{ __('addworking.components.billing.outbound.received_payment.index.table_row_empty') }}</span>
        </div>
    @endforelse
@endsection
