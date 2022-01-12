@if ($skill->exists)
    <input type="hidden" name="skill[id]" value="{{ $skill->id }}">
@endif

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.common.skill._form.general_information') }}</legend>

    @form_group([
        'text'        => __('addworking.common.skill._form.skill'),
        'name'        => "skill.display_name",
        'value'       => optional($skill)->display_name,
    ])

    @form_group([
        'text'        => __('addworking.common.skill._form.description'),
        'type'        => "textarea",
        'name'        => "skill.description",
        'value'       => optional($skill)->description,
    ])
</fieldset>
