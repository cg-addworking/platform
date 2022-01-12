<div class="row">
    <div class="col-md-12">
        @form_group([
            'name'        => "mission.label" ,
            'value'       => $mission->label,
            'required'    => true,
            'text'        => __('addworking.mission.mission._form.assignment_purpose'),
            'help'        => __('addworking.mission.mission._form.project_development_help'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @form_group([
        'type'        => "select",
        'name'        => "mission.location",
        'value'       => $mission->location,
        'options'     => mission()::getAvailableLocations(),
        'required'    => true,
        'text'        => __('addworking.mission.mission._form.location'),
        ])
    </div>

    <div class="col-md-6">
        @form_group([
        'name'        => "mission.external_id",
        'value'       => $mission->external_id,
        'text'        => __('mission.mission.external_id'),
        'help'        => __('addworking.mission.mission._form.identifier_help'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @form_group([
            'type'        => "textarea",
            'name'        => "mission.description",
            'value'       => $mission->description,
            'required'    => true,
            'text'        => "Description",
            'help'        => __('addworking.mission.mission._form.describe_mission_help'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        @form_group([
            'type'        => "date",
            'name'        => "mission.starts_at",
            'value'       => $mission->starts_at,
            'required'    => true,
            'text'        => __('mission.mission.starts_at'),
        ])
    </div>
    <div class="col-md-4">
        @form_group([
            'type'        => "date",
            'name'        => "mission.ends_at",
            'value'       => $mission->ends_at,
            'text'        => __('mission.mission.ends_at'),
        ])
    </div>
    <div class="col-md-4">
        @form_group([
            'type'        => "select",
            'name'        => "mission.milestone_type",
            'value'       => $mission->milestone_type,
            'options'     => array_trans(array_mirror(milestone()::getAvailableMilestoneTypes()), 'mission.milestone.type.'),
            'text'        => __('addworking.mission.mission._form.tracking_mode'),
            'required'    => true,
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        @form_group([
            'type'        => "select",
            'name'        => "mission.unit",
            'value'       => $mission->unit,
            'options'     => array_trans($mission->getUnits(), 'mission.mission.unit_'),
            'text'        => __('mission.mission.unit'),
        ])
    </div>
    <div class="col-md-4">
        @form_group([
            'type'        => "number",
            'step'        => 1,
            'min'         => 1,
            'name'        => "mission.quantity",
            'value'       => $mission->quantity,
            'text'        => __('mission.mission.quantity'),
        ])
    </div>
    <div class="col-md-4">
        @form_group([
            'type'        => "number",
            'step'        => .01,
            'min'         => 0,
            'name'        => "mission.unit_price",
            'value'       => $mission->unit_price,
            'text'        => __('mission.mission.unit_price')
        ])
    </div>
    
</div>
