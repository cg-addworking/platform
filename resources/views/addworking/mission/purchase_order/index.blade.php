@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.purchase_order.index.order_form')." {$enterprise->name}")

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.purchase_order.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.purchase_order.index.enterprise').'|href:'.$enterprise->routes->index )
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.mission.purchase_order.index.purchase_order')."|active")
@endsection

@section('table.colgroup')
    <col width="15%">
    <col width="35%">
    <col width="15%">
    <col width="10%">
    <col width="20%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.mission.purchase_order.index.mission_reference').'|not_allowed')
    @th(__('addworking.mission.purchase_order.index.assignment_purpose').'|not_allowed')
    @th(__('addworking.mission.purchase_order.index.creation_date').'|column:created_at')
    @th(__('addworking.mission.purchase_order.index.ht_price').'|not_allowed')
    @th(__('addworking.mission.purchase_order.index.status').'|not_allowed')
    @th(__('addworking.mission.purchase_order.index.action').'|not_allowed')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $purchase_order)
        <tr>
            <td>{{ $purchase_order->mission->number }}</td>
            <td>{{ $purchase_order->mission->views->link }}</td>
            <td>@date($purchase_order->created_at)</td>
            <td>{{float_to_money($purchase_order->mission->amount)}}</td>
            <td>@include('addworking.mission.purchase_order._status')</td>
            <td class="text-center">
                <a href="{{ $purchase_order->routes->show }}" class="btn btn-small">
                    <i class="text-muted fa fa-eye"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
