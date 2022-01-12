@if ($code->exists)
    <input type="hidden" name="code[id]" value="{{ $code->id }}">
@endif

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('edenred.common.code._form.general_information') }}</legend>

    @form_group([
        'type'     => "select",
        'text'     => __('edenred.common.code._form.bussiness_competence'),
        'name'     => "skill.id",
        'value'    => optional($code)->skill->id,
        'required' => true,
        'options'  => optional($code)->getAvailableSkills(),
    ])

    @form_group([
        'type'     => "text",
        'text'     => __('edenred.common.code._form.level'),
        'name'     => "code.level",
        'value'    => optional($code)->level,
        'required' => true,
    ])

    @form_group([
        'type'     => "text",
        'text'     => __('edenred.common.code._form.code'),
        'name'     => "code.code",
        'value'    => optional($code)->code,
        'required' => true,
    ])
</fieldset>
