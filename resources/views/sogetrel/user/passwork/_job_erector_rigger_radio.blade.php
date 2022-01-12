<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_erector_rigger_radio.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.erector_rigger_radio.level",
            'value'  => array_get($passwork->data, 'erector_rigger_radio.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_erector_rigger_radio.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_erector_rigger_radio.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_erector_rigger_radio.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.help_1') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.help_2') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.help_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.reads_blueprints",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.reads_blueprints'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_2') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.coaxial_connector_grounding_installation",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.coaxial_connector_grounding_installation'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_3') }}
            @endslot
        @endcomponent
    </div>
    
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.indoor_installation",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.indoor_installation'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_4') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.railway_environment_installation",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.railway_environment_installation'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_5') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.confidential_defense_empowerment",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.confidential_defense_empowerment'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_6') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.erector_rigger_radio.connection_radio_equipment.",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment'),
            'values'   => [
                '4g'    =>  __('sogetrel.user.passwork._job_erector_rigger_radio.4g'),
                '5g'    =>  __('sogetrel.user.passwork._job_erector_rigger_radio.5g'),
                'tetra' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.tetra'),
                'wifi'  =>  __('sogetrel.user.passwork._job_erector_rigger_radio.wifi'),
                'lora'  =>  __('sogetrel.user.passwork._job_erector_rigger_radio.lora'),
                'gsm-r' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.gsm-r'),
                'other' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.other'),
            ],
            'height'   => '9em',
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_7') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.erector_rigger_radio.work_height_pylon_roof_water_tower",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.work_height_pylon_roof_water_tower'),
            'values'   => [1 => __('sogetrel.user.passwork._job_erector_rigger_radio.yes'), 0 => __('sogetrel.user.passwork._job_erector_rigger_radio.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_8') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.erector_rigger_radio.measure_tools.",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.measure_tools'),
            'values'   => [
                'optical' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.optical'),
                'radio'   =>  __('sogetrel.user.passwork._job_erector_rigger_radio.radio'),
                'pim'     =>  __('sogetrel.user.passwork._job_erector_rigger_radio.pim'),
            ],
            'height'   => '9em',
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_9') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.erector_rigger_radio.operator.",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.operator'),
            'values'   => [
                'orange'   =>  __('sogetrel.user.passwork._job_erector_rigger_radio.orange'),
                'bouygues' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.bouygues'),
                'free'     =>  __('sogetrel.user.passwork._job_erector_rigger_radio.free'),
                'sfr'      =>  __('sogetrel.user.passwork._job_erector_rigger_radio.sfr'),
                'other'    =>  __('sogetrel.user.passwork._job_erector_rigger_radio.other'),
           ],
            'height'   => '9em',
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_10') }}
            @endslot
        @endcomponent
    </div>
    
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.erector_rigger_radio.equipment.",
            'value'    => array_get($passwork->data, 'erector_rigger_radio.equipment'),
            'values'   => [
                'huawei'   =>  __('sogetrel.user.passwork._job_erector_rigger_radio.huawei'),
                'ericsson' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.ericsson'),
                'nokia'    =>  __('sogetrel.user.passwork._job_erector_rigger_radio.nokia'),
                'comscope' =>  __('sogetrel.user.passwork._job_erector_rigger_radio.comscope'),
                'zte'      =>  __('sogetrel.user.passwork._job_erector_rigger_radio.zte'),
                'kapsch'   =>  __('sogetrel.user.passwork._job_erector_rigger_radio.kapsch'),
                'other'    =>  __('sogetrel.user.passwork._job_erector_rigger_radio.other'),
           ],
            'height'   => '9em',
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_radio.label_11') }}
            @endslot
        @endcomponent
    </div>
</div>
