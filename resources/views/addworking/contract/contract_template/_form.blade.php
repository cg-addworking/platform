<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_template._form.general_information') }}</legend>

    @form_group([
        'text'        => __('addworking.contract.contract_template._form.model_name'),
        'type'        => "text",
        'name'        => "contract_template.display_name",
        'value'       => optional($contract_template)->display_name,
        'required'    => true,
    ])

    @form_group([
        'text'        => __('addworking.contract.contract_template._form.model'),
        'type'        => "textarea",
        'rows'        => 25,
        'name'        => "contract_template.markdown",
        'value'       => optional($contract_template)->markdown,
        'required'    => true,
    ])
</fieldset>
