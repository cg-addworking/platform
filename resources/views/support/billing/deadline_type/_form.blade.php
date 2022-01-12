<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') Informations Générales</legend>

    @form_group([
        'text'     => "Label",
        'name'     => "deadline_type.display_name",
        'value'    => optional($deadline_type)->display_name,
        'required' => true,
    ])

    @form_group([
        'text'     => "Valeur",
        'name'     => "deadline_type.value",
        'type'     => "number",
        'value'    => optional($deadline_type)->value,
        'min'      => '0',
        'step'     => '1',
        'required' => true,
    ])

    @form_group([
        'text'  => "Description",
        'name'  => "deadline_type.description",
        'value' => optional($deadline_type)->description,
        'type'  => "textarea",
        'required' => true,
    ])
</fieldset>
