@extends('foundation::layout.app.create', ['action' => $action ?? $response->routes->store, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.proposal_response.create.respond_offer').': '. $offer->label)

@section('toolbar')
    @button(__('addworking.mission.proposal_response.create.return')."|href:".route('enterprise.offer.proposal.response.index', [ $offer->customer, $offer, $proposal])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal_response.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.proposal_response.create.mission_proposal').'|href:'.route('mission.proposal.index') )
    @breadcrumb_item(__('addworking.mission.proposal_response.create.create_response')."|active")
@endsection

@section('form')
<input type="hidden" name="response[proposal_id]" value="{{ $proposal->id }}">
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.proposal_response.create.general_information') }}</legend>
        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.create.possible_start_date'),
                    'type'        => "date",
                    'name'        => "response.starts_at",
                    'required'    => true
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.create.availability_end_date'),
                    'type'        => "date",
                    'name'        => "response.ends_at",
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.create.price'),
                    'type'        => "number",
                    'name'        => "response.unit_price",
                    'min'         => 0,
                    'step'        => "0.01",
                    'value'       => 0
                ])
            </div>
            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.create.unit'),
                    'type'        => "select",
                    'name'        => "response.unit",
                    'options'     => array_trans(array_mirror(proposal_response()::getAvailableUnits()), 'mission.mission.'),
                    'value'       => proposal_response()::UNIT_DAYS,
                ])
            </div>
            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.create.amount'),
                    'type'        => "number",
                    'name'        => "response.quantity",
                    'min'         => 0,
                    'step'        => "0.01",
                    'value'       => 0
                ])
            </div>
        </div>

        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.proposal_response.create.additional_file') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'type'        => "file",
                    'name'        => "response.files.",
                ])
            </div>
        </div>

    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.proposal_response.create.create_response1')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
