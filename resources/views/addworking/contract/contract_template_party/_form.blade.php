<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_template_party._form.general_information') }}</legend>

    @form_group([
        'text' => __('addworking.contract.contract_template_party._form.denomination'),
        'name' => "contract_template_party.denomination",
        'required' => true,
    ])
</fieldset>
