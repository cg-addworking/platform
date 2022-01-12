<div class="row">
    <div data-shown-if="#electrician:1,#technician:1">
        <div class="col-md-12">
            @component('components.form.group', [
                'type'     => "checkbox_list",
                'name'     => "passwork.data.electrical_clearances.",
                'value'    => array_get($passwork->data, 'electrical_clearances'),
                'id'       => "electrical_clearances",
                'values'   => [
                    'h1vb1v'    => __('sogetrel.user.passwork._tab3.h1vb1v'),
                    'b0vh0v'    => __('sogetrel.user.passwork._tab3.b0vh0v'),
                    'b2v_bcbr'  => __('sogetrel.user.passwork._tab3.b2v_bcbr'),
                    'irve'      => __('sogetrel.user.passwork._tab3.irve'),
                    'ev_ready'  => __('sogetrel.user.passwork._tab3.ev_ready'),
                    'other'     => __('sogetrel.user.passwork._tab3.other')
                ],
                'required' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._tab3.label_1') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-12" data-shown-if="#electrical_clearances input[value=other]:checked">
            @component('components.form.group', [
                'type'     => "textarea",
                'name'     => "passwork.data.electrical_clearances_other",
                'value'    => array_get($passwork->data, 'electrical_clearances_other'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._tab3.label_1b') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-12">
            @component('components.form.group', [
                'type'     => "checkbox_list",
                'name'     => "passwork.data.caces_ability.",
                'value'    => array_get($passwork->data, 'caces_ability'),
                'values'   => [
                    'r436' => __('sogetrel.user.passwork._tab3.r436'), 
                    'r482' => __('sogetrel.user.passwork._tab3.r482'),
                    'r489' => __('sogetrel.user.passwork._tab3.r489'),
                    'other' => __('sogetrel.user.passwork._tab3.other')
                    ]
                ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._tab3.label_2') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-12" data-shown-if="#caces_ability input[value=other]:checked">
            @component('components.form.group', [
                'type'     => "textarea",
                'name'     => "passwork.data.caces_ability_other",
                'value'    => array_get($passwork->data, 'caces_ability_other'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._tab3.label_6') }}
                @endslot
            @endcomponent
        </div>

        <div>
            <div class="col-md-6">
                @component('components.form.group', [
                    'type'     => "select",
                    'name'     => "passwork.data.work_height_ability",
                    'value'    => array_get($passwork->data, 'work_height_ability'),
                    'values'   => [
                        '1' => __('sogetrel.user.passwork._tab3.yes'),
                        '0' => __('sogetrel.user.passwork._tab3.no')
                        ]
                    ])
                    @slot('label')
                        {{ __('sogetrel.user.passwork._tab3.label_3') }}
                    @endslot
                @endcomponent
            </div>

            <div class="col-md-6">
                @component('components.form.group', [
                    'type'     => "select",
                    'name'     => "passwork.data.work_with_ropes",
                    'value'    => array_get($passwork->data, 'work_with_ropes'),
                    'values'   => [
                        '1' => __('sogetrel.user.passwork._tab3.yes'),
                        '0' => __('sogetrel.user.passwork._tab3.no')
                        ]
                    ])
                    @slot('label')
                        {{ __('sogetrel.user.passwork._tab3.label_4') }}
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>

    <div class="col-md-12" data-shown-if="#electrician:1,#technician:1,#civil_engineering:1,#technicien_cavi:1">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.other_clearances.",
            'value'    => array_get($passwork->data, 'other_clearances'),
            'id'       => "other_clearances",
            'values'   => [
                'ss4'       => __('sogetrel.user.passwork._tab3.ss4'),
                'aipr'      => __('sogetrel.user.passwork._tab3.aipr'),
                'other'     => __('sogetrel.user.passwork._tab3.other')
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.label_5') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.software_supervision.",
            'value'    => array_get($passwork->data, 'software_supervision'),
            'id'       => "software_supervision",
            'values'   => [
                'genetec'   => __('sogetrel.user.passwork._tab3.genetec'),
                'milestone' => __('sogetrel.user.passwork._tab3.milestone'),
                'casd'     => __('sogetrel.user.passwork._tab3.casd'),
                'flir'     => __('sogetrel.user.passwork._tab3.flir'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.software_supervision') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.camera_mark.",
            'value'    => array_get($passwork->data, 'camera_mark'),
            'id'       => "camera_mark",
            'values'   => [
                'axis' => __('sogetrel.user.passwork._tab3.axis'),
                'bosch' => __('sogetrel.user.passwork._tab3.bosch'),
                'hanwah' => __('sogetrel.user.passwork._tab3.hanwah'),
                'hik' => __('sogetrel.user.passwork._tab3.hik'),
                'dahua' => __('sogetrel.user.passwork._tab3.dahua'),
                'flir' => __('sogetrel.user.passwork._tab3.flir'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.camera_mark') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.software_supervision_marks.",
            'value'    => array_get($passwork->data, 'software_supervision_marks'),
            'id'       => "software_supervision_marks",
            'values'   => [
                'nedap' => __('sogetrel.user.passwork._tab3.nedap'),
                'til' => __('sogetrel.user.passwork._tab3.til'),
                'genetec' => __('sogetrel.user.passwork._tab3.genetec'),
                'vanderbilt' => __('sogetrel.user.passwork._tab3.vanderbilt'),
                'synchronic' => __('sogetrel.user.passwork._tab3.synchronic'),
                'alcea' => __('sogetrel.user.passwork._tab3.alcea'),
                'honeywell' => __('sogetrel.user.passwork._tab3.honeywell'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.software_supervision_marks') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.opportunities.",
            'value'    => array_get($passwork->data, 'opportunities'),
            'id'       => "opportunities",
            'values'   => [
                'gallagher' => __('sogetrel.user.passwork._tab3.gallagher'),
                'ccure' => __('sogetrel.user.passwork._tab3.ccure'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.opportunities') }}
            @endslot
        @endcomponent
    </div>  

    <div class="col-md-12" data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.hypervision.",
            'value'    => array_get($passwork->data, 'hypervision'),
            'id'       => "hypervision",
            'values'   => [
                'prysm' => __('sogetrel.user.passwork._tab3.prysm'),
                'saratec' => __('sogetrel.user.passwork._tab3.saratec'),
                'obs' => __('sogetrel.user.passwork._tab3.obs'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.hypervision') }}
            @endslot
        @endcomponent
    </div>  


    <div class="col-md-12" data-shown-if="#other_clearances input[value=other]:checked">
        @component('components.form.group', [
            'type'     => "textarea",
            'name'     => "passwork.data.precision_clearances_other",
            'value'    => array_get($passwork->data, 'precision_clearances_other'),
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.label_6') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#electrician:1,#technician:1,#civil_engineering:1,#engineering_office:1">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.licenses.",
            'value'    => array_get($passwork->data, 'licenses'),
            'id'       => "licenses",
            'values'   => [
                'b' => __('sogetrel.user.passwork._tab3.b'), 
                'c' => __('sogetrel.user.passwork._tab3.c'),
                'e' => __('sogetrel.user.passwork._tab3.e')
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.label_7') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12" data-shown-if="#engineering_office:1">
        @component('components.form.group', [
            'type'     => "textarea",
            'name'     => "passwork.data.qualifications",
            'value'    => array_get($passwork->data, 'qualifications'),
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab3.label_8') }}
            @endslot
        @endcomponent
    </div>
</div>
