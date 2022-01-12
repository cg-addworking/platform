@if ($job->exists)
    <input type="hidden" name="job[id]" value="{{ $job->id }}">
@endif

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.common.job._form.general_information') }}</legend>

    @if ($parents = optional($job)->getAvailableParents()) @form_group([
        'text'        => __('addworking.common.job._form.parent'),
        'type'        => "select",
        'name'        => "job.parent",
        'value'       => optional($job)->display_name,
        'options'     => $parents,
    ]) @endif

    @form_group([
        'text'        => __('addworking.common.job._form.job'),
        'name'        => "job.display_name",
        'value'       => optional($job)->display_name,
    ])

    @form_group([
        'text'        => __('addworking.common.job._form.description'),
        'type'        => "textarea",
        'name'        => "job.description",
        'value'       => optional($job)->description,
    ])
</fieldset>
