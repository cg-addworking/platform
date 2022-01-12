<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.model.application.views.contract_model._form.general_information') }}</legend>

    @form_group([
        'text'        => __('components.contract.model.application.views.contract_model._form.display_name'),
        'type'        => "text",
        'name'        => "contract_model.display_name",
        'value'       => optional($contract_model)->getDisplayName(),
        'required'    => true,
    ])

    @form_group([
        'text'         => __('components.contract.model.application.views.contract_model._form.enterprise'),
        'type'         => "select",
        'name'         => "contract_model.enterprise",
        'value'        => optional($contract_model->getEnterprise())->id,
        'options'      => $enterprises,
        'required'     => true,
        'selectpicker' => true,
        'search'       => true,
    ])

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="contract_model[should_vendors_fill_their_variables]" value="1" id="should_vendors_fill_their_variables" {{optional($contract_model)->getShouldVendorsFillTheirVariables() ? "checked" : ""}} class="form-check-input shadow-sm">
            <label class="form-check-label">
                {{__('components.contract.model.application.views.contract_model._form.should_vendors_fill_their_variables')}}
            </label>
        </div>
    </div>
</fieldset>
