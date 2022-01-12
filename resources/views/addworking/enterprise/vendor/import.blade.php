@extends('layout.app.create', ['action' => route('addworking.enterprise.vendor.load', $enterprise), 'enctype' => "multipart/form-data"])

@section('title', __('addworking.enterprise.vendor.import.import_providers'))

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.vendor.import.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:".$enterprise->routes->index)
    @breadcrumb_item("{$enterprise->name}|href:".$enterprise->routes->show)
    @breadcrumb_item(__('addworking.enterprise.vendor.import.my_providers')."|href:".route('addworking.enterprise.vendor.index', $enterprise))
    @breadcrumb_item("Import|active")
@endsection

@section('form')
    @form_group([
        'type'     => "file",
        'name'     => "file",
        'required' => true,
        'accept'   => '.csv',
        'text'     => __('addworking.enterprise.vendor.import.csv_file'),
    ])

    <div class="text-right my-5">
        @button(__('addworking.enterprise.vendor.import.import')."|type:submit|color:primary|shadow|icon:upload")
    </div>
@endsection