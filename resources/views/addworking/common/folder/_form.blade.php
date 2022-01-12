<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.common.folder._form.general_information') }}</legend>

    @form_group([
        'text'     => __('addworking.common.folder._form.folder_name'),
        'type'     => 'text',
        'required' => true,
        'name'     => 'folder.display_name',
        'value'    => optional($folder)->display_name
    ])

    @form_group([
        'text'         => __('addworking.common.folder._form.owner'),
        'type'         => 'select',
        "options"      => $folder->enterprise->users->pluck('name', 'id'),
        "required"     => true,
        "selectpicker" => true,
        "search"       => true,
        'name'         => 'folder.created_by',
        'value'        => optional(optional($folder)->createdBy)->id,
    ])

    @form_group([
        'text'     => __('addworking.common.folder._form.visible_to_providers'),
        'type'     => 'switch',
        'name'     => 'folder.shared_with_vendors',
        'value'    => 1 ?? 0,
    ])
</fieldset>
