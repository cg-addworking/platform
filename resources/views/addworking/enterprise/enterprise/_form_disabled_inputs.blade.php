<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.enterprise._form_disabled_inputs.general_information') }}</legend>
    <div class="alert alert-warning">@icon('exclamation-triangle') {{ __('addworking.enterprise.enterprise._form_disabled_inputs.contact_support') }}</div>
    <div class="row">
        <div class="col-md-2">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.legal_form'),
                'type'        => "select",
                'name'        => "enterprise.legal_form_id",
                'value'       => optional($enterprise)->legalForm->id,
                'options'     => legal_form([])->pluck('display_name', 'id'),
                'required'    => true,
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
        <div class="col-md-8">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.social_reason'),
                'type'        => "text",
                'name'        => "enterprise.name",
                'value'       => optional($enterprise)->name,
                'placeholder' => __('addworking.enterprise.enterprise._form_disabled_inputs.company_name'),
                'required'    => true,
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
        <div class="col-md-2">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.structure_created'),
                'type'        => "switch",
                'name'        => "enterprise.structure_in_creation",
                'value'       => 1,
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
    </div>

        <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.siret_number'),
                'type'        => "text",
                'name'        => "enterprise.identification_number",
                'value'       => optional($enterprise)->identification_number,
                'placeholder' => "99999999999999",
                'pattern'     => "\d{9}\s?\d{5}",
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.company_registered_at'),
                'type'        => "text",
                'name'        => "enterprise.registration_town",
                'value'       => optional($enterprise)->registration_town,
                'required'    => true,
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.vat_number'),
                'type'        => "text",
                'name'        => "enterprise.tax_identification_number",
                'value'       => optional($enterprise)->tax_identification_number,
                'placeholder' => "FR99999999999",
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form_disabled_inputs.external_identifier'),
                'type'        => "text",
                'name'        => "enterprise.external_id",
                'value'       => optional($enterprise)->external_id,
                '_attributes' => [ 'disabled' => 'disabled' ],
            ])
        </div>
    </div>
</fieldset>

<input type="hidden" value="{{$enterprise->country}}" id="input_hidden_country_code">

@push('scripts')
    <script>
        var check_enterprise_country = function (value) {
            if (value === '{{\Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface::CODE_DEUTSCHLAND}}') {
                $("#div_main_activity_code").hide();
                $('#div_contractualization_language').show();
                $("input[name='enterprise[contractualization_language]']").attr('required', true);
                $("input[name='enterprise[main_activity_code]']").prop('disabled', true);
                $("input[name='enterprise[main_activity_code]']").attr('required', false);
                $('#enterprise_activity_field_input_container').hide();
                $("select[name='enterprise_activity[field]']").prop('disabled', true);
                $("select[name='enterprise_activity[field]']").attr('required', false);
                $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'de')}}");
                $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'de')}}");
                $('#tax_identification_number_input_container input').attr('placeholder', 'DE1234');
                $('#siret-number-input-container input').attr('placeholder', '');
                $('#siret-number-input-container small').attr('placeholder', '');
            } else {
                $("#div_main_activity_code").show();
                $('#div_contractualization_language').hide();
                $("input[name='enterprise[contractualization_language]']").attr('required', false);
                $("input[name='enterprise[main_activity_code]']").prop('disabled', false);
                $("input[name='enterprise[main_activity_code]']").attr('required', true);
                $('#enterprise_activity_field_input_container').show();
                $("select[name='enterprise_activity[field]']").prop('disabled', false);
                $("select[name='enterprise_activity[field]']").attr('required', true);
                $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'fr')}}");
                $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'fr')}}");
                $('#tax_identification_number_input_container input').attr('placeholder', 'FR99999999999');
                $('#siret-number-input-container input').attr('placeholder', '99999999999999');
            }
        };

        $('#enterprise_country').on('change', function() {
            const selected_enterprise_country = $(this).val();
            check_enterprise_country(selected_enterprise_country);
        })

        check_enterprise_country($('#input_hidden_country_code').val());
    </script>
@endpush
