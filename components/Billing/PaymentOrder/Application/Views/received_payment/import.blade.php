@extends('layout.app.create', ['action' => route('support.received_payment.load'), 'enctype' => "multipart/form-data"])

@section('title', __('addworking.components.billing.outbound.received_payment.import.title'))

@section('breadcrumb')
    @breadcrumb_item(__('addworking.components.billing.outbound.received_payment.import._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.components.billing.outbound.received_payment.import._breadcrumb.import')."|active")
@endsection

@section('form')
    @form_group([
        'type'     => "file",
        'name'     => "file",
        'required' => true,
        'accept'   => '.csv',
        'text'     => __('addworking.components.billing.outbound.received_payment.import._form.csv_file'),
    ])

    <div class="text-right my-5">
        @button(__('addworking.components.billing.outbound.received_payment.import.import')."|type:submit|color:primary|shadow|icon:upload")
    </div>
@endsection
