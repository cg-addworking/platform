@extends('foundation::layout.app.create', ['action' => route('sogetrel.mission.proposal.bpu.store', $proposal), 'enctype' => 'multipart/form-data'])

@section('title', __('sogetrel.mission.proposal.bpu.create.attach_bpu'))

@section('toolbar')
    @button(__('sogetrel.mission.proposal.bpu.create.return')."|href:".route('mission.proposal.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('sogetrel.mission.proposal.bpu.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel.mission.proposal.bpu.create.mission_proposal').'|href:'.route('mission.proposal.index') )
    @breadcrumb_item(__('sogetrel.mission.proposal.bpu.create.create_bpu')."|active")
@endsection

@section('form')
    <fieldset class="mt-2 pt-2">
        @form_group([
        'type'        => "file",
        'name'        => "bpu_file",
        'required'    => true,
        'accept'      => 'application/pdf',
        'text'        => __('sogetrel.mission.proposal.bpu.create.join_bpu'),
        ])

     <div class="text-right my-5">
        @button(__('sogetrel.mission.proposal.bpu.create.send_bpu')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
