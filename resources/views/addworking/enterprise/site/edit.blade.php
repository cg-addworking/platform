@extends('foundation::layout.app.create', ['action' => $site->routes->update,'method' => 'PUT'])

@section('title', __('addworking.enterprise.site.edit.edit_site'))

@section('toolbar')
    @button(__('addworking.enterprise.site.edit.return')."|href:{$site->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.site.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item('Sites|href:'.$site->routes->index )
    @breadcrumb_item($site->display_name .'|href:'.$site->routes->show )
    @breadcrumb_item(__('addworking.enterprise.site.edit.edit')."|active")
@endsection

@section('form')
    <input type="hidden" name="site.enterprise_id" value="{{ $enterprise->id }}">

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.site.edit.general_information') }}</legend>

        <div class="row">

            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.last_name'),
                    'name'        => "site.display_name",
                    'type'        => "text",
                    'value'       => $site->display_name,
                    'required'    => true,
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.analytical_code'),
                    'name'        => "site.analytic_code",
                    'value'       => $site->analytic_code,
                    'type'        => "text",
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.site.edit.main_address') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.address_line_1'),
                    'type'        => "text",
                    'name'        => "address.address",
                    'value'       => optional($site->addresses->first())->address,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.address_line_2'),
                    'type'        => "text",
                    'name'        => "address.additionnal_address",
                    'value'       => optional($site->addresses->first())->additionnal_address,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.postal_code'),
                    'type'        => "text",
                    'name'        => "address.zipcode",
                    'value'       => optional($site->addresses->first())->zipcode,
                ])
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.enterprise.site.edit.city'),
                    'type'        => "text",
                    'name'        => "address.town",
                    'value'       => optional($site->addresses->first())->town,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.site.edit.record')."|type:submit|color:warning|shadow|icon:save")
    </div>
@endsection

@push('scripts')
    <script>
        $('input[name="site[display_name]"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endpush
