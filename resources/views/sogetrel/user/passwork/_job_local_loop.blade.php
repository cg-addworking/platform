<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_local_loop.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.local_loop.level",
            'value'    => array_get($passwork->data, 'local_loop.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_local_loop.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_local_loop.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_local_loop.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_local_loop.help_1') }}
                {{ __('sogetrel.user.passwork._job_local_loop.help_2') }}
                {{ __('sogetrel.user.passwork._job_local_loop.help_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.years_of_experience",
            'value'    => array_get($passwork->data, 'local_loop.years_of_experience'),
            'values'   => [
                'less_than_1'     => __('sogetrel.user.passwork._job_local_loop.less_than_1'),
                'more_than_3'     => __('sogetrel.user.passwork._job_local_loop.more_than_3')
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_2') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.reads_blueprints",
            'value'    => array_get($passwork->data, 'local_loop.reads_blueprints'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.understands_cable_blueprint",
            'value'    => array_get($passwork->data, 'local_loop.understands_cable_blueprint'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_4') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.differenciates_cables",
            'value'    => array_get($passwork->data, 'local_loop.differenciates_cables'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_5') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.cable_connection_rules",
            'value'    => array_get($passwork->data, 'local_loop.cable_connection_rules'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_6') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.electrical_measures",
            'value'    => array_get($passwork->data, 'local_loop.electrical_measures'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_7') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.local_loop.optical_measures",
            'value'    => array_get($passwork->data, 'local_loop.optical_measures'),
            'values'   => [1 => __('sogetrel.user.passwork._job_local_loop.yes'), 0 => __('sogetrel.user.passwork._job_local_loop.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_local_loop.label_8') }}
            @endslot
        @endcomponent
    </div>
</div>
