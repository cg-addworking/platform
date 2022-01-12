<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.legal_form._form.general_information') }}</legend>

    @form_group([
        'text'     => __('addworking.enterprise.legal_form._form.wording'),
        'name'     => "legal_form.display_name",
        'value'    => optional($legal_form)->display_name,
        'required' => true,
    ])

    @form_group([
        'text'     => __('addworking.enterprise.legal_form._form.acronym'),
        'name'     => "legal_form.name",
        'value'    => optional($legal_form)->name,
        'required' => true,
        'disabled' => $page === 'edit'
    ])

    @form_group([
        'text'     => "Pays",
        'name'     => "legal_form.country",
        'value'    => optional($legal_form)->country,
        'required' => true,
        'type'     => 'select',
        'options'  => array_mirror(legal_form()::getAvailableCountries()),
        'disabled' => $page === 'edit'
    ])
</fieldset>
