@if ($contract->id)
    <input type="hidden" name="contract[id]" value="{{ $contract->id }}">
@endif

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract._form.contract_properties') }}</legend>

    @form_group([
        'text'        => __('addworking.contract.contract._form.last_name'),
        'name'        => "contract.name",
        'value'       => $contract->name ?? Repository::contract()->newName($contract),
        'required'    => true,
    ])

    @form_group([
        'text'        => __('addworking.contract.contract._form.contract_start_date'),
        'type'        => "date",
        'name'        => "contract.valid_from",
        'value'       => $contract->valid_from,
        'placeholder' => "dd/mm/YYY",
    ])

    @form_group([
        'text'        => __('addworking.contract.contract._form.contract_due_date'),
        'type'        => "date",
        'name'        => "contract.valid_until",
        'value'       => $contract->valid_until,
        'placeholder' => "dd/mm/YYY",
    ])

    @form_group([
        'text'        => __('addworking.contract.contract._form.external_identifier'),
        'name'        => "contract.external_identifier",
        'value'       => $contract->external_identifier,
    ])
</fieldset>
