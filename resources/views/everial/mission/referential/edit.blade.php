@extends('foundation::layout.app.edit', ['action' => $referential->routes->update, 'enctype' => 'multipart/form-data'])

@section('title', __('everial.mission.referential.edit.edit_mission_repo'))

@section('toolbar')
    @button(__('everial.mission.referential.edit.return')."|href:{$referential->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('everial.mission.referential.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('everial.mission.referential.edit.referential_missions').'|href:'.$referential->routes->index )
    @breadcrumb_item($referential->label .'|href:'.$referential->routes->show )
    @breadcrumb_item(__('everial.mission.referential.edit.edit')."|active")
@endsection

@section('form')
    {{ $referential->views->form }}

    <fieldset class="mt-3 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('everial.mission.referential.edit.best_bidder') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => __('everial.mission.referential.edit.best_bidder'),
                'name'        => "referential.best_bidder",
                'type'        => "select",
                'value'       => $referential->bestBidder->id ?? '',
                'options'     => $referential->getPositionedVendors()->pluck('name', 'id'),
                'required'    => false,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('everial.mission.referential.edit.save')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
