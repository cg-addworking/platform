@if(optional($enterprise_activity)->enterprise)
    <input type="hidden" name="enterprise[id]" value="{{ $enterprise_activity->enterprise->id }}">
@endif

<div class="row">
    <div class="col-md-8">
        @form_group([
            'type'      => "text",
            'name'      => "enterprise_activity.activity",
            'value'     => optional($enterprise_activity)->activity,
            'text'      => __('enterprise.enterprise_activity.activity'),
            'required'  => true,
            'help'      => __('addworking.enterprise.enterprise_activity._form.enterprise_activity_help'),
            'maxlength' => 255,
        ])
    </div>
    <div class="col-md-4" id="div_main_activity_code">
        @form_group([
            'text'        => __('addworking.enterprise.enterprise._form.main_activity_code'),
            'type'        => "text",
            'name'        => "enterprise.main_activity_code",
            'value'       => optional($enterprise_activity->enterprise)->main_activity_code,
            'placeholder' => "0000X",
            'required'    => true,
            'help'        => __('addworking.enterprise.enterprise.create.ape_code_help'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        @form_group([
            'type'     => "number",
            'name'     => "enterprise_activity.employees_count",
            'value'    => optional($enterprise_activity)->employees_count,
            'text'     => __('enterprise.enterprise_activity.employees_count'),
            'required' => true,
        ])
    </div>

    <div class="col-md-8">
        @form_group([
            'type'     => "select",
            'options'  => enterprise_activity()::getAvailableFields(),
            'name'     => "enterprise_activity.field",
            'value'    => optional($enterprise_activity)->field,
            'text'     => __('enterprise.enterprise_activity.field'),
            'required' => true,
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @form_group([
            'type'         => "select",
            'options'      => department()::options(),
            'multiple'     => true,
            'selectpicker' => true,
            'search'       => true,
            'name'         => "enterprise_activity.departments.",
            'value'        => old("enterprise_activity.departments" ,optional($enterprise_activity)->departments->pluck('id')),
            'text'         => __('enterprise.enterprise_activity.departments'),
            'help'         => __('addworking.enterprise.enterprise_activity._form.select_multiple_departments_help')
        ])
    </div>
</div>
