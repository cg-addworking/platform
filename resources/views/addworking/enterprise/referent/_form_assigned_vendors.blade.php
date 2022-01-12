<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('user-friends') {{ __('addworking.enterprise.referent._form_assigned_vendors.general_information') }}</legend>

    @form_group([
        'type'         => "select",
        'text'         => __('addworking.enterprise.referent._form_assigned_vendors.provider_of')." ". $enterprise->name,
        'name'         => " vendors.",
        'value'        => $user->referentVendorsOf($enterprise)->get(),
        'options'      => $enterprise->vendors->pluck('name','id'),
        'selectpicker' => true,
        'multiple'     => true,
        'search'       => true
    ])

</fieldset>
