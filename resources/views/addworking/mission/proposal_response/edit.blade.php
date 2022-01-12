@extends('foundation::layout.app.create', ['action' => $response->routes->update, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.proposal_response.edit.edit_response'))

@section('toolbar')
    @button(__('addworking.mission.proposal_response.edit.return')."|href:".route('enterprise.offer.proposal.response.show', [$offer->customer, $offer, $proposal, $response])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal_response.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.proposal_response.edit.mission_proposal').'|href:'.route('mission.proposal.index') )
    @breadcrumb_item(__('addworking.mission.proposal_response.edit.edit_response1')."|active")
@endsection

@section('form')
    @method('PUT')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.proposal_response.edit.general_information') }}</legend>

        <div class="row">

            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.edit.possible_start_date'),
                    'type'        => "date",
                    'name'        => "response.starts_at",
                    'required'    => true,
                    'value'       => $response->starts_at
                ])
            </div>

            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.edit.availability_end_date'),
                    'type'        => "date",
                    'name'        => "response.ends_at",
                    'value'       => $response->ends_at
                ])
            </div>

        </div>

        <div class="row">

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.edit.price'),
                    'type'        => "number",
                    'name'        => "response.unit_price",
                    'min'         => 0,
                    'step'        => "0.01",
                    'value'       => $response->unit_price
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.edit.unit'),
                    'type'        => "select",
                    'name'        => "response.unit",
                    'options'     => array_trans(array_mirror(proposal_response()::getAvailableUnits()), 'mission.response.unit.'),
                    'value'       => $response->unit
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.proposal_response.edit.amount'),
                    'type'        => "number",
                    'name'        => "response.quantity",
                    'min'         => 0,
                    'step'        => "0.01",
                    'value'       => $response->quantity
                ])
            </div>

        </div>

        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.proposal_response.edit.additional_file') }}</legend>

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
        @button(__('addworking.mission.proposal_response.edit.edit_response')."|type:submit|color:warning|shadow|icon:edit")
    </div>
@endsection
