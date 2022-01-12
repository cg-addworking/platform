<fieldset class="mt-2 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('enterprise.resource.application.views._form.resource_properties') }}</legend>

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.last_name'),
        'type'     => "text",
        'name'     => "resource.last_name",
        'value'    => optional($resource)->getLastName(),
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.first_name'),
        'type'     => "text",
        'name'     => "resource.first_name",
        'value'    => optional($resource)->getFirstName(),
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.email'),
        'type'     => "email",
        'required' => true,
        'name'     => "resource.email",
        'value'    => optional($resource)->getEmail(),
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.registration_number'),
        'type'     => "text",
        'name'     => "resource.registration_number",
        'value'    => optional($resource)->getRegistrationNumber(),
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.status'),
        'type'     => "select",
        'options'  => Repository::resource()->getAvailableStatuses(),
        'name'     => 'resource.status',
        'value'    => optional($resource)->getStatus(),
        'required' => true,
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.note'),
        'type'     => "textarea",
        'name'     => "resource.note",
        'value'    => optional($resource)->getNote(),
    ])

    @form_group([
        'type'        => "file",
        'accept'      => 'application/pdf',
        'name'        => "resource.file",
        'text'        => __('enterprise.resource.application.views._form.file'),
    ])
</fieldset>

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('enterprise.resource.application.views._form.assign_client') }}</legend>

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.assign.client'),
        'type'     => "select",
        'name'     => "resource.activity_period.customer_id",
        'options'  => $resource->vendor->customers->pluck('name', 'id'),
        'required' => true,
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.assign.start_date'),
        'type'     => "date",
        'name'     => "resource.activity_period.starts_at",
        'required' => true,
    ])

    @form_group([
        'text'     => __('enterprise.resource.application.views._form.assign.end_date'),
        'type'     => "date",
        'name'     => "resource.activity_period.ends_at"
    ])
</fieldset>
