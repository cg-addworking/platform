@extends('foundation::layout.app.create', ['action' => route('tse_express_medical.mission.load'), 'enctype' => "multipart/form-data"])

@section('title', __('tse_express_medical.mission.import.import_mission'))

@section('breadcrumb')
    @breadcrumb_item(__('tse_express_medical.mission.import.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('tse_express_medical.mission.import.missions'))
    @breadcrumb_item(__('tse_express_medical.mission.import.import_mission')."|active")
@endsection

@section('form')
    @form_group([
        'type'     => "file",
        'name'     => "file",
        'required' => true,
        'accept'   => '.csv',
        'text'     => __('tse_express_medical.mission.import.csv_file'),
    ])

    <div class="text-right my-5">
        @button(__('tse_express_medical.mission.import.upload')."|type:submit|color:primary|shadow|icon:upload")
    </div>
@endsection
