@extends('foundation::layout.app.create', ['action' => $proposal->routes->update, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.proposal.edit.modify_proposal'))

@section('toolbar')
    @button(__('addworking.mission.proposal.edit.return')."|href:".route('mission.proposal.show', $proposal)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.proposal.edit.mission_proposal').'|href:'.route('mission.proposal.index') )
    @breadcrumb_item($proposal->label .'|href:'.route('mission.proposal.show', $proposal) )
    @breadcrumb_item(__('addworking.mission.proposal.edit.edit')."|active")
@endsection

@section('form')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                @component('components.panel')
                    <h4>{{ __('addworking.mission.proposal.edit.mission_offer') }}</h4>
                    {{ $proposal->missionOffer->label }}
                @endcomponent
            </div>

            <div class="mb-3">
                @component('components.panel')
                    <h4>{{ __('addworking.mission.proposal.edit.service_provider') }}</h4>
                    {{ $proposal->passwork->user->name }} @if($proposal->vendor->exists) | {{ $proposal->vendor->name }} @endif
                @endcomponent
            </div>

            @component('components.panel')
                <h4>{{ __('addworking.mission.proposal.edit.mission_proposal_info') }}</h4>

                @form_group([
                    'text'        => __('mission.mission.external_id'),
                    'type'        => "text",
                    'name'        => "mission_proposal.external_id",
                    'value'       => $proposal->external_id,
                ])

                @form_group([
                    'type'        => "date",
                    'name'        => "mission_proposal.valid_from",
                    'value'       => $proposal->valid_from,
                    'required'    => true,
                    'text'        => __('mission.proposal.valid_from'),
                    'placeholder' => __('mission.proposal.valid_from_placeholder'),
                ])

                @form_group([
                    'type'        => "date",
                    'name'        => "mission_proposal.valid_until",
                    'value'       => $proposal->valid_until,
                    'text'        => __('mission.proposal.valid_until'),
                    'placeholder' => __('mission.proposal.valid_until_placeholder'),
                ])

                @form_group([
                    'type'        => "select",
                    'name'        => "mission_proposal.need_quotation",
                    'value'       => $proposal->need_quotation,
                    'options'     => [0 => 'Non', 1 => 'Oui'],
                    'required'    => true,
                    'text'        => __('mission.proposal.need_quotation.label'),
                ])

                @form_group([
                    'type'        => "select",
                    'name'        => "mission_proposal.unit",
                    'value'       => $proposal->unit,
                    'options'     => array_trans(mission_proposal()::getAvailableUnits(), 'mission.mission.unit_'),
                    'text'        => __('mission.mission.unit'),
                ])

                @form_group([
                    'type'        => "number",
                    'step'        => 1,
                    'name'        => "mission_proposal.quantity",
                    'value'       => $proposal->quantity,
                    'text'        => __('mission.mission.quantity'),
                ])

                @form_group([
                    'type'        => "number",
                    'step'        => .01,
                    'name'        => "mission_proposal.unit_price",
                    'value'       => $proposal->unit_price,
                    'text'        => __('mission.mission.unit_price')
                ])

                @form_group([
                    'name'     => "mission_proposal.details",
                    'type'     => "textarea",
                    'value'    => $proposal->details,
                    'text'     => __('mission.proposal.details'),
                ])
            @endcomponent

            @component('components.panel')
                <div class="text-right">
                    @if($proposal->isDraft())
                        <button type="submit" name="mission_proposal[status]" value="{{ mission_proposal()::STATUS_DRAFT }}" class="btn btn-primary"><i class="fa fa-check"></i> @lang('messages.save_draft')</button>
                    @endif
                    <button type="submit" name="mission_proposal[status]" value="{{ mission_proposal()::STATUS_UNDER_NEGOTIATION }}" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
                </div>
            @endcomponent
        </div>
    </div>
@endsection
