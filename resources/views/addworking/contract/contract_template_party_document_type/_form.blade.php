<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_template_party_document_type._form.general_information') }}</legend>

    @form_group([
        'type'     => "select",
        'name'     => "document_type.id",
        'text'     => __('addworking.contract.contract_template_party_document_type._form.type_of_document'),
        'options'  => $enterprise->documentTypes->pluck('name', 'id'),
        'required' => true,
    ])

    @form_group([
        'type'     => "switch",
        'name'     => "contract_template_party_document_type.mandatory",
        'text'     => __('addworking.contract.contract_template_party_document_type._form.mandatory_document'),
        'value'    => 1,
    ])

    @form_group([
        'type'     => "switch",
        'name'     => "contract_template_party_document_type.validation_required",
        'text'     => __('addworking.contract.contract_template_party_document_type._form.validation_required'),
        'value'    => 1,
    ])
</fieldset>
