<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.has_worked_with_in_civil_engineering.",
            'value'    => array_get($passwork->data, 'has_worked_with_in_civil_engineering'),
            'id'       => "has_worked_with_in_civil_engineering",
            'options'   => [
                'office_studies' => __('sogetrel.user.passwork._job_civil_engineering.office_studies'),
                'vrd' => __('sogetrel.user.passwork._job_civil_engineering.vrd'),
                'repair' => __('sogetrel.user.passwork._job_civil_engineering.repair'),
                'posts_with_auger' => __('sogetrel.user.passwork._job_civil_engineering.posts_with_auger'),
                'posts_with_hands' => __('sogetrel.user.passwork._job_civil_engineering.posts_with_hands'),
                'street_cabinets' => __('sogetrel.user.passwork._job_civil_engineering.street_cabinets'),
                'telecom_room' => __('sogetrel.user.passwork._job_civil_engineering.telecom_room'),
                'trenchless_networks' => __('sogetrel.user.passwork._job_civil_engineering.trenchless_networks'),
                'management_procedures' => __('sogetrel.user.passwork._job_civil_engineering.management_procedures'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_civil_engineering.label') }}
            @endslot
        @endcomponent
    </div>
</div>
