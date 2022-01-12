@extends('foundation::layout.app.show')

@section('title', __('addworking.mission.purchase_order.show.order_form')."  ".$mission->label)

@section('toolbar')
    @can('send', $purchaseOrder)
        <a class="btn btn-outline-success btn-sm ml-2" href="#" onclick="confirm('{{ __('addworking.mission.purchase_order.show.send_order_form') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            <i class="far fa-envelope mr-2"></i> {{ __('addworking.mission.purchase_order.show.send_to_service_provider_and_referrer') }}
        </a>
        @push('modals')
            <form name="{{ $name }}" action="{{ $mission->purchaseOrder->routes->send }}" method="POST">
                <input type="hidden" name="purchase_order[status]" value="{{ purchase_order()::STATUS_SENT }}">
                @csrf
            </form>
        @endpush
    @endcan
    @button(__('addworking.mission.purchase_order.show.return')."|href:".$mission->routes->show."|icon:arrow-left|color:secondary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.purchase_order.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.purchase_order.show.enterprise').'|href:'.$enterprise->routes->show )
    @breadcrumb_item(__('addworking.mission.purchase_order.show.mission').'|href:'.$mission->routes->show )
    @breadcrumb_item(__('addworking.mission.purchase_order.show.purchase_order')."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-file-tab" data-toggle="tab" href="#nav-file" role="tab" aria-controls="nav-file" aria-selected="true">{{ __('addworking.mission.purchase_order.show.purchase_order') }}</a>
    <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="true">{{ __('addworking.mission.purchase_order.show.details') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-file" role="tabpanel" aria-labelledby="nav-file-tab">
        {{ $purchaseOrder->file->views->iframe }}
    </div>

    <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
        <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ __('addworking.mission.purchase_order.show.order_form_help_text') }}
        </div>
    </div>
@endsection
