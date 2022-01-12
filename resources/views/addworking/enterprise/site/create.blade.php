@extends('foundation::layout.app.create', ['action' => $site->routes->store])

@section('title', __('addworking.enterprise.site.create.create_new_site'))

@section('toolbar')
    @button(__('addworking.enterprise.site.create.return')."|href:{$site->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.site.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.site.create.create_site')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.site.create.general_information') }}</legend>

        <div class="row">
            <input type="hidden" name="site.enterprise_id" value="{{ $enterprise->id }}">

            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.last_name'),
                    'name'        => "site.display_name",
                    'type'        => "text",
                    'required'    => true,
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.analytical_code'),
                    'name'        => "site.analytic_code",
                    'type'        => "text",
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.site.create.main_address') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.address_line_1'),
                    'type'        => "text",
                    'name'        => "address.address",
                    'required'    => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.address_line_2'),
                    'type'        => "text",
                    'name'        => "address.additionnal_address",
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.postal_code'),
                    'type'        => "text",
                    'name'        => "address.zipcode",
                    'required'    => true,
                ])
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.city'),
                    'type'        => "text",
                    'name'        => "address.town",
                    'required'    => true,
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('phone') Contact</legend>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.telephone_1'),
                    'type'        => "tel",
                    'name'        => "phone_number.1.number",
                    'pattern'     => "\d{10}",
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                'text'        => "Note",
                'type'        => "textarea",
                'name'        => "phone_number.1.note",
                'pattern'     => "\d{10}",
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.telephone_2'),
                    'type'        => "tel",
                    'name'        => "phone_number.2.number",
                    'pattern'     => "\d{10}",
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                'text'        => "Note",
                'type'        => "textarea",
                'name'        => "phone_number.2.note",
                'pattern'     => "\d{10}",
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.create.telephone_3'),
                    'type'        => "tel",
                    'name'        => "phone_number.3.number",
                    'pattern'     => "\d{10}",
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                'text'        => "Note",
                'type'        => "textarea",
                'name'        => "phone_number.3.note",
                'pattern'     => "\d{10}",
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.site.create.create_sites')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script>
        $('input[name="site[display_name]"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endpush
