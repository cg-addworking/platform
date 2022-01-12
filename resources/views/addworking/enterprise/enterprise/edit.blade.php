@extends('foundation::layout.app.create', ['action' => $enterprise->routes->update, 'enctype' => 'multipart/form-data', 'method' => 'POST'])

@section('title', strtoupper($enterprise->legalForm->display_name) . ' ' . $enterprise->name)

@section('toolbar')
    @button(__('addworking.enterprise.enterprise.edit.return')."|href:{$enterprise->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("Entreprise ".strtoupper($enterprise->legalForm->display_name)." {$enterprise->name}|href:{$enterprise->routes->show}" )
    @breadcrumb_item(__('addworking.enterprise.enterprise.edit.modifier')."|active")
@endsection

@section('form')
    @support
        <fieldset class="mt-5 pt-2">
            <legend class="text-primary h5">@icon('handshake') {{ __('addworking.enterprise.enterprise.edit.business_type') }}</legend>
            <div class="row">
                <div class="col-md-3">
                    @form_group([
                        'text'        => __('addworking.enterprise.enterprise.edit.service_provider'),
                        'type'        => "switch",
                        'name'        => "enterprise.vendor",
                        'checked'     => $enterprise->is_vendor,
                    ])
                </div>
                <div class="col-md-3">
                    @form_group([
                        'text'        => "Client",
                        'type'        => "switch",
                        'name'        => "enterprise.customer",
                        'checked'     => $enterprise->is_customer,
                    ])
                </div>
            </div>
        </fieldset>

        @if ($enterprise->users->count() > 1)
            <fieldset class="mt-5 pt-2">
                <legend class="text-primary h5">{{ __('addworking.enterprise.enterprise.edit.choice_legal_representative') }}</legend>

                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.edit.legal_representative'),
                    'type'        => "select",
                    'name'        => "enterprise.legal_representative.",
                    'options'     => $enterprise->users->pluck('name', 'id'),
                    'value'       => $enterprise->legalRepresentatives->pluck('id')->toArray(),
                    'multiple'    => true,
                    'required'    => true,
                ])

                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.edit.sign'),
                    'type'        => "select",
                    'name'        => "enterprise.signatories.",
                    'options'     => $enterprise->users->pluck('name', 'id'),
                    'value'       => $enterprise->signatories->pluck('id')->toArray(),
                    'multiple'    => true,
                    'required'    => true,
                ])
            </fieldset>
        @endif
    @endsupport

    @if(Auth::user()->isSupport())
        {{ $enterprise->views->form }}
    @else
        {{ $enterprise->views->form_disabled_inputs }}
    @endif

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.enterprise.edit.activity') }}</legend>
        {{ $enterprise->activity->views->form }}
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.enterprise.edit.main_address') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => __('addworking.enterprise.enterprise.edit.address_line_1'),
                'type'        => "text",
                'name'        => "address.address",
                'value'       => optional($enterprise->address)->address,
                'required'    => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => __('addworking.enterprise.enterprise.edit.address_line_2'),
                'type'        => "text",
                'name'        => "address.additionnal_address",
                'value'       => optional($enterprise->address)->additionnal_address,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                @form_group([
                'text'        => __('addworking.enterprise.enterprise.edit.postal_code'),
                'type'        => "text",
                'name'        => "address.zipcode",
                'value'       => optional($enterprise->address)->zipcode,
                'required'    => true,
                ])
            </div>
            <div class="col-md-9">
                @form_group([
                'text'        => __('addworking.enterprise.enterprise.edit.city'),
                'type'        => "text",
                'name'        => "address.town",
                'value'       => optional($enterprise->address)->town,
                'required'    => true,
                ])
            </div>
        </div>

        @if($enterprise->isCustomer())
            <div class="row">
                <div class="col-md-3">
                    @if ($enterprise->logo->exists)
                        <img src="{{ $enterprise->logo->common_url }}"  class=" picture person img-thumbnail">
                    @else
                        pas de logo
                    @endif

                </div>
                <div class="col-md-9">
                    @form_group([
                    'type'     => "file",
                    'name'     => "enterprise.logo",
                    'text'     => __('enterprise.enterprise.logo'),
                    'required' => false,
                    ])
                </div>
            </div>
        @endif
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.enterprise.edit.record')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
