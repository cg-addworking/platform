@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.site.phone_number.store', [$enterprise, $site])])

@section('title', __('addworking.enterprise.site.phone_number.create.add_phone_number')." $site->display_name")

@section('toolbar')
    @button(__('addworking.enterprise.site.phone_number.create.return')."|href:".$site->routes->show."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.site.phone_number.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.$enterprise->routes->index )
    @breadcrumb_item(title_case($enterprise->name) .'|href:'.$enterprise->routes->show )
    @breadcrumb_item(title_case($site->display_name) .'|href:'.$site->routes->show )
    @breadcrumb_item(__('addworking.enterprise.site.phone_number.create.dashboard')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('phone') {{ __('addworking.enterprise.site.phone_number.create.phone') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'     => __('addworking.enterprise.site.phone_number.create.phone_number'),
                'type'     => "tel",
                'name'     => "phone_number.number",
                'pattern'  => "\d{10}",
                'required' => true,
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'     => "Note",
                'type'     => "textarea",
                'name'     => "phone_number.note",
                'required' => false,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.site.phone_number.create.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
