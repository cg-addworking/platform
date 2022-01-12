<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_party_document_type._form.properties') }}</legend>

    @form_group([
        'text' => __('addworking.contract.contract_party_document_type._form.mandatory'),
        'type' => "select",
        'name' => "contract_party_document_type.mandatory",
        'value' => optional($contract_party_document_type)->mandatory ?? "0",
        'options' => ["0" => "Non",  "1" => "Oui"],
    ])

    @form_group([
        'text' => __('addworking.contract.contract_party_document_type._form.validation_required'),
        'type' => "select",
        'name' => "contract_party_document_type.validation_required",
        'value' => optional($contract_party_document_type)->validation_required ?? "0",
        'options' => ["0" => "Non",  "1" => "Oui"],
    ])
</fieldset>
