<div class="row">
    <div class="col-md-12">
        <b>{{ __('sogetrel.user.passwork._job_software.title') }}</b>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.engineering_office_software.dao_software.",
            'value'    => array_keys(array_get($passwork->data, "engineering_office_software.dao_software", [])),
            'values'   => [
                'autocad'        => __('sogetrel.user.passwork._job_software.autocad'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_software.label_1') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.engineering_office_software.sig_software.",
            'value'    => array_keys(array_get($passwork->data, "engineering_office_software.sig_software", [])),
            'values'   => [
                'qgis'     => __('sogetrel.user.passwork._job_software.qgis'),
                'arcgis'   => __('sogetrel.user.passwork._job_software.arcgis'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_software.label_2') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-12">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.engineering_office_software.business_software.",
            'value'    => array_keys(array_get($passwork->data, "engineering_office_software.business_software", [])),
            'values'   => [
                'ipon'          => __('sogetrel.user.passwork._job_software.ipon'),
                'geofibre'      => __('sogetrel.user.passwork._job_software.geofibre'),
                'optimum'       => __('sogetrel.user.passwork._job_software.optimum'),
                'cap_ft'        => __('sogetrel.user.passwork._job_software.cap_ft'),
                'comac'         => __('sogetrel.user.passwork._job_software.comac'),
                'fiberscript_h' => __('sogetrel.user.passwork._job_software.fiberscript_h'),
                'fiberscript_v' => __('sogetrel.user.passwork._job_software.fiberscript_v'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_software.label_3') }}
            @endslot
        @endcomponent
    </div>
</div>
