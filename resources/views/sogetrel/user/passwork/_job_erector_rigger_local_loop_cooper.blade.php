<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.erector_rigger_local_loop_cooper.level",
            'value'  => array_get($passwork->data, 'erector_rigger_local_loop_cooper.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.help_1') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.help_2') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.help_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.years_of_experience",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.years_of_experience'),
            'values'   => [
                'less_than_1'     => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.less_than_1'),
                'more_than_3'     => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.more_than_3')
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_2') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.reads_blueprints",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.reads_blueprints'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.understands_cable_blueprint",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.understands_cable_blueprint'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_4') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.differenciates_cables",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.differenciates_cables'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_5') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.cable_connection_rules",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.cable_connection_rules'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_6') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_local_loop_cooper.electrical_measures",
            'value'    => array_get($passwork->data, 'erector_rigger_local_loop_cooper.electrical_measures'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper.label_7') }}
            @endslot
        @endcomponent
    </div>
</div>
