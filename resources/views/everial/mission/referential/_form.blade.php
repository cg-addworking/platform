<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('everial.mission.referential._form.general_information') }}</legend>
    <div class="row">
        <div class="col-md-4">
            @form_group([
            'text'        => __('everial.mission.referential._form.shipping_site'),
            'name'        => "referential.shipping_site",
            'value'       => optional($referential)->shipping_site,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
        <div class="col-md-8">
            @form_group([
            'text'        => __('everial.mission.referential._form.shipping_address'),
            'name'        => "referential.shipping_address",
            'value'       => optional($referential)->shipping_address,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @form_group([
            'text'        => __('everial.mission.referential._form.destination_site'),
            'name'        => "referential.destination_site",
            'value'       => optional($referential)->destination_site,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
        <div class="col-md-8">
            @form_group([
            'text'        => __('everial.mission.referential._form.destination_address'),
            'name'        => "referential.destination_address",
            'value'       => optional($referential)->destination_address,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'        => __('everial.mission.referential._form.distance'),
            'name'        => "referential.distance",
            'value'       => optional($referential)->distance,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @form_group([
            'text'        => __('everial.mission.referential._form.pallet_type'),
            'name'        => "referential.pallet_type",
            'value'       => optional($referential)->pallet_type,
            'type'        => "text",
            'required'    => true,
            ])
        </div>
        <div class="col-md-8">
            @form_group([
            'text'        => __('everial.mission.referential._form.pallet_number'),
            'name'        => "referential.pallet_number",
            'value'       => optional($referential)->pallet_number,
            'type'        => "number",
            'min'         => 1,
            'step'        => 1,
            'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'        => __('everial.mission.referential._form.analytic_code'),
            'name'        => "referential.analytic_code",
            'value'       => optional($referential)->analytic_code,
            'type'        => "text",
            'required'    => false,
            ])
        </div>
    </div>
</fieldset>