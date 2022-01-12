@inject('sectorRepository', 'Components\Enterprise\WorkField\Application\Repositories\SectorRepository')
@inject('enterpriseRepository', 'App\Repositories\Addworking\Enterprise\EnterpriseRepository')
<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.enterprise._form.general_information') }}</legend>

    <div class="row">
        <div class="col-md-2">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.country'),
                'type'        => "select",
                'name'        => "enterprise.country",
                'value'       => old('enterprise.country', $enterprise->country),
                'options'     => enterprise([])->getAvailableCountry(),
                'required'    => true,
                'id'          => 'enterprise_country',
            ])
        </div>
        <div class="col-md-2">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.legal_form'),
                'type'        => "select",
                'name'        => "enterprise.legal_form_id",
                'value'       => old('enterprise.legal_form_id', optional($enterprise)->legalForm->id),
                'options'     => legal_form([])->pluck('display_name', 'id'),
                'required'    => true,
                'id'          => 'legal-form-id',
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.social_reason'),
                'type'        => "text",
                'name'        => "enterprise.name",
                'value'       => optional($enterprise)->name,
                'placeholder' => __('addworking.enterprise.enterprise._form.company_name'),
                'required'    => true,
            ])
        </div>
        <div class="col-md-2">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.structure_created'),
                'type'        => "switch",
                'name'        => "enterprise.structure_in_creation",
                'value'       => 1,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="siret-number-input-container">
            @form_group([
            'text'        => __('addworking.enterprise.enterprise._form.siret_number'),
            'type'        => "text",
            'name'        => "enterprise.identification_number",
            'value'       => old('enterprise.identification_number', optional($enterprise)->identification_number),
            'placeholder' => "99999999999999",
            'help'        => __('addworking.enterprise.enterprise._form.siren_14_digit_help'),
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.company_registered_at'),
                'type'        => "text",
                'name'        => "enterprise.registration_town",
                'value'       => optional($enterprise)->registration_town,
                'required'    => true,
            ])
        </div>
        <div class="col-md-3" id="div_registration_date">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.registration_date'),
                'type'        => "date",
                'name'        => "enterprise.registration_date",
                'value'       => optional($enterprise)->getRegistrationDate(),
                'required'    => true,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" id="tax_identification_number_input_container">
            @form_group([
            'text'        => __('addworking.enterprise.enterprise._form.vat_number'),
            'type'        => "text",
            'name'        => "enterprise.tax_identification_number",
            'value'       => optional($enterprise)->tax_identification_number,
            'placeholder' => "FR99999999999",
            ])
        </div>
        <div class="col-md-6" id="external_id_input_container">
            @form_group([
            'text'        => __('addworking.enterprise.enterprise._form.external_identifier'),
            'type'        => "text",
            'name'        => "enterprise.external_id",
            'value'       => optional($enterprise)->external_id,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-4" id="div_contractualization_language" style="display:none">
            @form_group([
            'text'        => __('addworking.enterprise.enterprise._form.contractualization_language'),
            'type'        => "select",
            'options'     => [
            "de" => __('addworking.enterprise.enterprise.language.german'),
            "en" => __('addworking.enterprise.enterprise.language.english'),
            ],
            'name'        => "enterprise.contractualization_language",
            'value'       => optional($enterprise)->getContractualizationLanguage(),
            'required'    => true,
            ])
        </div>
    </div>
    @support
    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.business_plus'),
                'type'        => "switch",
                'name'        => "enterprise.business_plus",
                'checked'     => $enterprise->is_business_plus,
                'help'        => __('addworking.enterprise.enterprise._form.business_plus_message')
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('addworking.enterprise.enterprise._form.collect_business_turnover'),
                'type'        => "switch",
                'name'        => "enterprise.collect_business_turnover",
                'checked'     => $enterprise->collect_business_turnover,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            @form_group([
                'text'     => __('addworking.enterprise.enterprise.edit.sectors'),
                'type'     => "select",
                'name'     => "enterprise.sectors.",
                'options'  => $sectorRepository->getAvailableSectors(),
                'value'    => $enterprise->sectors->pluck('id')->toArray(),
                'multiple' => true,
                'selectpicker' => true,
            ])
        </div>
    </div>
    @endsupport
</fieldset>

@push('scripts')
<script>
    var check_enterprise_country = function (value) {
        if (value === '{{\Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface::CODE_DEUTSCHLAND}}') {
            $("#div_main_activity_code").hide();
            $("#external_id_input_container").hide();
            $('#div_contractualization_language').show();
            $("select[name='enterprise[contractualization_language]']").prop('disabled', false);
            $("select[name='enterprise[contractualization_language]']").attr('required', true);
            $("input[name='enterprise[main_activity_code]']").prop('disabled', true);
            $("input[name='enterprise[main_activity_code]']").attr('required', false);
            $('#enterprise_activity_field_input_container').hide();
            $("select[name='enterprise_activity[field]']").prop('disabled', true);
            $("select[name='enterprise_activity[field]']").attr('required', false);
            $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'de')}}");
            $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'de')}}");
            $("input[name='enterprise[registration_date]']").attr('required', true);
            $("#div_registration_date").show();
            $('#tax_identification_number_input_container input').attr('placeholder', 'DE1234');
            $('#siret-number-input-container input').attr('placeholder', '');
            $('#siret-number-input-container small').attr('placeholder', '');
        } else {
            $("#div_main_activity_code").show();
            $("#external_id_input_container").show();
            $('#div_contractualization_language').hide();
            $("select[name='enterprise[contractualization_language]']").prop('disabled', true);
            $("select[name='enterprise[contractualization_language]']").attr('required', false);
            $("input[name='enterprise[main_activity_code]']").prop('disabled', false);
            $("input[name='enterprise[main_activity_code]']").attr('required', true);
            $('#enterprise_activity_field_input_container').show();
            $("select[name='enterprise_activity[field]']").prop('disabled', false);
            $("select[name='enterprise_activity[field]']").attr('required', true);
            $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'fr')}}");
            $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'fr')}}");
            $("input[name='enterprise[registration_date]']").attr('required', false);
            $("#div_registration_date").hide();
            $('#tax_identification_number_input_container input').attr('placeholder', 'FR99999999999');
            $('#siret-number-input-container input').attr('placeholder', '99999999999999');
        }
    };

    $('#enterprise_country').on('change', function() {
        const selected_enterprise_country = $(this).val();
        check_enterprise_country(selected_enterprise_country);
    });

    check_enterprise_country($('#enterprise_country').val());
</script>
@endpush
