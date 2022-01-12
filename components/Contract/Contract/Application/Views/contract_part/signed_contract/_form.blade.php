@form_group([
    'text'        => __('components.contract.contract.application.views.contract_part._form.display_name'),
    'type'        => "text",
    'name'        => "contract_part.display_name",
    'required'    => true,
])

<div class="form-group mb-3" id="div-file">
@form_group([
        'type'        => "file",
        'name'        => "contract_part.file",
        'required'    => true,
        'id'          => 'input-group-file',
        'accept'      => 'application/pdf',
        'text'        => __('components.contract.contract.application.views.contract_part._form.file'),
    ])
</div>
