@extends('layout.app.create', ['action' => route('tracking_line.load'), 'enctype' => "multipart/form-data"])

@section('title', __('tracking_line::tracking_line.import.title'))

@section('breadcrumb')
    @breadcrumb_item(__('tracking_line::tracking_line.import._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('tracking_line::tracking_line.import._breadcrumb.tracking_lines')."|active")
    @breadcrumb_item(__('tracking_line::tracking_line.import._breadcrumb.import')."|active")
@endsection

@section('form')
    @form_group([
        'type'     => "file",
        'name'     => "file",
        'required' => true,
        'accept'   => '.csv',
        'text'     => __('tracking_line::tracking_line.import._form.csv_file'),
    ])

    <div class="text-right my-5">
        @button(__('tracking_line::tracking_line.import.import')."|type:submit|color:primary|shadow|icon:upload")
    </div>
@endsection
