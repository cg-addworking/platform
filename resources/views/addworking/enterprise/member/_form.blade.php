<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('user-tie') {{ __('addworking.enterprise.member._form.general_information') }}</legend>

    @form_group([
        'text'        => __('addworking.enterprise.member._form.fonction'),
        'type'        => "text",
        'name'        => "member.job_title",
        'value'       => optional($user)->getJobTitleFor($enterprise),
        'placeholder' => __('addworking.enterprise.member._form.general_project_manager'),
    ])
</fieldset>

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('user-tag'){{__('addworking.enterprise.member._form.role')}}</legend>

    @form_group([
        'type'        => "checkbox_list",
        'name'        => "member.roles.",
        'value'       => optional($user)->getRolesFor($enterprise),
        'options'     => optional($user)->getAvailableRoles(true),
    ])
</fieldset>

@if(auth()->user()->isSupport())
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('door-open') {{ __('addworking.enterprise.member._form.access_application') }}</legend>

        @form_group([
            'type'        => "checkbox_list",
            'name'        => "member.accesses.",
            'value'       => optional($user)->getAccessesFor($enterprise),
            'options'     => optional($user)->getAvailableAccess(true),
        ])
    </fieldset>
@endif
