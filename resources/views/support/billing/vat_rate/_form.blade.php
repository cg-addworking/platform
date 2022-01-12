<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') Informations Générales</legend>

    @form_group([
        'text'     => "Label",
        'name'     => "vat_rate.display_name",
        'value'    => optional($vat_rate)->display_name,
        'required' => true,
    ])

    @form_group([
        'text'     => "Valeur",
        'name'     => "vat_rate.value",
        'type'     => "number",
        'value'    => optional($vat_rate)->value*100,
        'min'      => '0',
        'max'      => '100',
        'step'     => '1',
        'required' => true,
    ])

    @form_group([
        'text'  => "Description",
        'name'  => "vat_rate.description",
        'value' => optional($vat_rate)->description,
        'type'  => "textarea",
    ])
</fieldset>
