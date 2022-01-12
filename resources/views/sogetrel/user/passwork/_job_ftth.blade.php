<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_ftth.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.ftth.level",
            'value'    => array_get($passwork->data, 'ftth.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_ftth.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_ftth.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_ftth.expert'),
            ],
             'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_ftth.help_1') }}
                {{ __('sogetrel.user.passwork._job_ftth.help_2') }}
                {{ __('sogetrel.user.passwork._job_ftth.help_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.read_electric_blueprints",
            'value'    => array_get($passwork->data, 'ftth.read_electric_blueprints'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_2') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.read_wiring_blueprints",
            'value'    => array_get($passwork->data, 'ftth.read_wiring_blueprints'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.differentiate_cables",
            'value'    => array_get($passwork->data, 'ftth.differentiate_cables'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.cable_connection_rules",
            'value'    => array_get($passwork->data, 'ftth.cable_connection_rules'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_5') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.electrical_measures",
            'value'    => array_get($passwork->data, 'ftth.electrical_measures'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_6') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.ftth.optical_measures",
            'value'    => array_get($passwork->data, 'ftth.optical_measures'),
            'values'   => [1 => __('sogetrel.user.passwork._job_ftth.yes'), 0 => __('sogetrel.user.passwork._job_ftth.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_ftth.label_7') }}
            @endslot
        @endcomponent
    </div>
</div>
