<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_optic_welder.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.optic_welder.level",
            'value'    => array_get($passwork->data, 'optic_welder.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_optic_welder.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_optic_welder.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_optic_welder.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_optic_welder.help_1') }}
                {{ __('sogetrel.user.passwork._job_optic_welder.help_2') }}
                {{ __('sogetrel.user.passwork._job_optic_welder.help_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.understands_cable_blueprint",
            'value'    => array_get($passwork->data, 'optic_welder.understands_cable_blueprint'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_2') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.differenciates_cables",
            'value'    => array_get($passwork->data, 'optic_welder.differenciates_cables'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.masters_optic_cable_rules",
            'value'    => array_get($passwork->data, 'optic_welder.masters_optic_cable_rules'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.masters_welding",
            'value'    => array_get($passwork->data, 'optic_welder.masters_welding'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_5') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.master_welder_tool",
            'value'    => array_get($passwork->data, 'optic_welder.master_welder_tool'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_6') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.masters_measuring_tools",
            'value'    => array_get($passwork->data, 'optic_welder.masters_measuring_tools'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_7') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic_welder.masters_optic_measuring_tools",
            'value'    => array_get($passwork->data, 'optic_welder.masters_optic_measuring_tools'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_welder.yes'), 0 => __('sogetrel.user.passwork._job_optic_welder.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_welder.label_8') }}
            @endslot
        @endcomponent
    </div>
</div>
