@extends('layout.app.create', ['action' => route('enterprise.offer.send-request-close', [$enterprise, $offer]), 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.offer.send_request_close.offer_close_req')." {$offer->label}")

@section('toolbar')
    @button(__('addworking.mission.offer.send_request_close.return')."|href:".route($back ?? 'mission.offer.show', $offer)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.send_request_close.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.send_request_close.mission_offer').'|href:'.route($back ?? 'mission.offer.index') )
    @breadcrumb_item("{$offer->label}|href:".route('mission.offer.show', $offer))
    @breadcrumb_item(__('addworking.mission.offer.send_request_close.offer_close_req')."|active")
@endsection

@section('form')
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">{{ __('addworking.mission.offer.send_request_close.offer_close_req') }}</h4>
        <p class="mb-0">
            {{ __('addworking.mission.offer.send_request_close.you_selected') }} {{ $numberOfResponses ?? '0' }} {{ __('addworking.mission.offer.send_request_close.you_selected_text') }} 
        </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                @section('form.redirect_member')
                    @form_group([
                        'text'        => __('addworking.mission.offer.send_request_close.solicit_responsible'),
                        'type'        => "select",
                        'name'        => "member",
                        'options'     => array_combine($usersCanCloseOffer->pluck('id')->all(), $usersCanCloseOffer->get()->map(fn($user) => $user->name)->all()),
                        'required'    => true,
                    ])
                @show
            @endcomponent

            <div class="text-right my-5">
                <button type="submit" class="border btn btn-success"><i class="fa fa-envelope"></i> {{ __('addworking.mission.offer.send_request_close.send_request') }}</button>
            </div>
@endsection
