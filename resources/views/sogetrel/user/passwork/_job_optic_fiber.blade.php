<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_optic_fiber.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.optic.level",
            'value'  => array_get($passwork->data, 'optic.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_optic_fiber.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_optic_fiber.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_optic_fiber.expert'),
            ],
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_optic_fiber.help_1') }}
                {{ __('sogetrel.user.passwork._job_optic_fiber.help_2') }}
                {{ __('sogetrel.user.passwork._job_optic_fiber.help_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.understands_measurment_curve",
            'value'    => array_get($passwork->data, 'optique.understands_measurment_curve'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_2') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.understands_cable_blueprint",
            'value'    => array_get($passwork->data, 'optic.understands_cable_blueprint'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.differenciates_cables",
            'value'    => array_get($passwork->data, 'optic.differenciates_cables'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.understance_optic_fiber_basics", // @todo fix typo here!
            'value'    => array_get($passwork->data, 'optic.understance_optic_fiber_basics'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_5') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.masters_connection_tools",
            'value'    => array_get($passwork->data, 'optic.masters_connection_tools'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_6') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optic.masters_measuring_tools",
            'value'    => array_get($passwork->data, 'optic.masters_measuring_tools'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optic_fiber.yes'), 0 => __('sogetrel.user.passwork._job_optic_fiber.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optic_fiber.label_7') }}
            @endslot
        @endcomponent
    </div>
</div>
