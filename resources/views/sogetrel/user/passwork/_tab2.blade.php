<section data-shown-if="#engineering_office:1">
    <div class="row">
        <div class="col-md-6">
            @component('components.form.group', [
                'type'     => "checkbox_list",
                'name'     => "passwork.data.has_worked_with_in_engineering_office.",
                'value'    => array_keys(array_get($passwork->data, 'has_worked_with_in_engineering_office', [])),
                'id'       => "has_worked_with_in_engineering_office",
                'values'   => [
                    'study_manager'    => __('sogetrel.user.passwork._tab2.study_manager'),
                    'qgis' => __('sogetrel.user.passwork._tab2.qgis'),
                    'gaia' => __('sogetrel.user.passwork._tab2.gaia'),
                    'ipon_geofibre' => __('sogetrel.user.passwork._tab2.ipon_geofibre'),
                    'kheops' => __('sogetrel.user.passwork._tab2.kheops'),
                    'netgeo' => __('sogetrel.user.passwork._tab2.netgeo'),
                    'drawer_drafter' => __('sogetrel.user.passwork._tab2.drawer_drafter'),
                    'exe' => __('sogetrel.user.passwork._tab2.exe'),
                    'grace_thd' => __('sogetrel.user.passwork._tab2.grace_thd'),
                    'aerial_studies' => __('sogetrel.user.passwork._tab2.aerial_studies'),
                    'gc_studies' => __('sogetrel.user.passwork._tab2.gc_studies'),
                    'security_studies' => __('sogetrel.user.passwork._tab2.security_studies'),
                    'gcblo_owf' => __('sogetrel.user.passwork._tab2.gcblo_owf'),
                    'telecom_picketer' => __('sogetrel.user.passwork._tab2.telecom_picketer'),
                ]
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._tab2.label_1') }}
                @endslot
            @endcomponent
        </div>
    </div>
</section>

<section data-shown-if="#civil_engineering:1">
    @include('sogetrel.user.passwork._job_civil_engineering')
</section>

<section data-shown-if="#electrician:1,#technician:1,#technicien_cavi:1">
    <div class="row">
        <div class="col-md-6">
            <b>{{ __('sogetrel.user.passwork._tab2.label_3') }}</b>

            @include('sogetrel.user.passwork._checkbox_list_level', [
                'name' => "passwork.data.wants_to_work_with.",
                'value' => array_keys(array_get($passwork->data, 'wants_to_work_with', [])),
                'id' => "wants_to_work_with",
                'options' => [
                    'linky' => __('sogetrel.user.passwork._tab2.linky'),
                    'gazpar' => __('sogetrel.user.passwork._tab2.gazpar'),
                    __('sogetrel.user.passwork._tab2.pstn_network') => [
                        'erector_rigger_local_loop_cooper' => __('sogetrel.user.passwork._tab2.erector_rigger_local_loop_cooper'),
                        'subscriber_technician_d3'         => __('sogetrel.user.passwork._tab2.subscriber_technician_d3')
                    ],
                    __('sogetrel.user.passwork._tab2.fiber_optic_network') => [
                        'local_loop' => __('sogetrel.user.passwork._tab2.local_loop'),
                        'erector_rigger_d2' => __('sogetrel.user.passwork._tab2.erector_rigger_d2'),
                        'optic_fiber' => __('sogetrel.user.passwork._tab2.optic_fiber'),
                        'ftth' => __('sogetrel.user.passwork._tab2.ftth'),
                        'optic_welder' => __('sogetrel.user.passwork._tab2.optic_welder'),
                        'optical_network_maintenance' => __('sogetrel.user.passwork._tab2.optical_network_maintenance')
                    ],
                    __('sogetrel.user.passwork._tab2.corporate_telecom_network') => [
                        'cpe_technician' => __('sogetrel.user.passwork._tab2.cpe_technician'),
                    ],
                    __('sogetrel.user.passwork._tab2.radio') => [
                        'erector_rigger_radio' => __('sogetrel.user.passwork._tab2.erector_rigger_radio'),
                    ],
                    __('sogetrel.user.passwork._tab2.electric_vehicle_charging_stations') => [
                        'electric_vehicle_charging_stations' => __('sogetrel.user.passwork._tab2.electric_vehicle_charging_stations2')
                    ],
                    'technicien_cavi' => __('sogetrel.user.passwork._tab2.technicien_cavi'),
                    'engineering_computer' => __('sogetrel.user.passwork._tab2.engineering_computer'),
                ]
            ])
        </div>
    </div>
</section>

<section data-shown-if="#has_worked_with_in_engineering_office input[value=study_manager]:checked">
    @include('sogetrel.user.passwork._job_study_manager')
</section>

<section data-shown-if="#has_worked_with_in_engineering_office input[value=drawer_drafter]:checked">
    @include('sogetrel.user.passwork._job_drawer_drafter')
</section>

<section data-shown-if="#has_worked_with_in_engineering_office input[value=telecom_picketer]:checked">
    @include('sogetrel.user.passwork._job_telecom_picketer')
</section>

<section data-shown-if="#has_worked_with_in_engineering_office input[value=study_manager]:checked,#has_worked_with_in_engineering_office input[value=drawer_drafter]:checked,#has_worked_with_in_engineering_office input[value=drawer]:checked,#has_worked_with_in_engineering_office input[value=telecom_picketer]:checked">
    @include('sogetrel.user.passwork._job_software')
</section>

<section data-shown-if="#wants_to_work_with input[value=gazpar]:checked">
    @include('sogetrel.user.passwork._job_gazpar')
</section>

<section data-shown-if="#wants_to_work_with input[value=linky]:checked">
    @include('sogetrel.user.passwork._job_linky')
</section>

<section data-shown-if="#wants_to_work_with input[value=ftth]:checked">
    @include('sogetrel.user.passwork._job_ftth')
</section>

<section data-shown-if="#wants_to_work_with input[value=optic_fiber]:checked">
    @include('sogetrel.user.passwork._job_optic_fiber')
</section>

<section data-shown-if="#wants_to_work_with input[value=local_loop]:checked">
    @include('sogetrel.user.passwork._job_local_loop')
</section>

<section data-shown-if="#wants_to_work_with input[value=erector_rigger_local_loop_cooper]:checked">
    @include('sogetrel.user.passwork._job_erector_rigger_local_loop_cooper')
</section>

<section data-shown-if="#wants_to_work_with input[value=erector_rigger_radio]:checked">
    @include('sogetrel.user.passwork._job_erector_rigger_radio')
</section>

<section data-shown-if="#wants_to_work_with input[value=cpe_technician]:checked">
    @include('sogetrel.user.passwork._job_cpe_technician')
</section>

<section data-shown-if="#wants_to_work_with input[value=optic_welder]:checked">
    @include('sogetrel.user.passwork._job_optic_welder')
</section>

<section data-shown-if="#wants_to_work_with input[value=optical_network_maintenance]:checked">
    @include('sogetrel.user.passwork._job_optical_network_maintenance')
</section>

<section data-shown-if="#wants_to_work_with input[value=subscriber_technician_d3]:checked">
    @include('sogetrel.user.passwork._job_subscriber_technician_d3')
</section>

<section data-shown-if="#wants_to_work_with input[value=erector_rigger_d2]:checked">
    @include('sogetrel.user.passwork._job_erector_rigger_d2')
</section>

<section data-shown-if="#wants_to_work_with input[value=electric_vehicle_charging_stations]:checked">
    @include('sogetrel.user.passwork._job_electric_vehicle_charging_stations')
</section>

<section data-shown-if="#wants_to_work_with input[value=technicien_cavi]:checked">
    @include('sogetrel.user.passwork._job_technicien_cavi')
</section>

<section data-shown-if="#wants_to_work_with input[value=engineering_computer]:checked">
    @include('sogetrel.user.passwork._job_engineering_computer')
</section>