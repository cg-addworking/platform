<form action="@yield('form-action', route('sogetrel.passwork.index'))" method="GET">
    @include('sogetrel.user.passwork._search_work_type')
    <div class="row">
        <div class="col-md-2">
            @component('components.form.group', [
                'type'    => "select",
                'multiple' => true,
                'name'    => "search.electrical_clearance.",
                'value'   => request()->input('search.electrical_clearance'),
                'values'   => [
                    'h1vb1v'   => __('sogetrel.user.passwork._search.h1vb1v'),
                    'b0vh0v'   => __('sogetrel.user.passwork._search.b0vh0v'),
                    'b2v_bcbr' => __('sogetrel.user.passwork._search.b2v_bcbr'),
                    'irve'     => __('sogetrel.user.passwork._search.irve'),
                    'ev_ready' => __('sogetrel.user.passwork._search.ev_ready'),
                    'other'    => __('sogetrel.user.passwork._search.other')
                ],
                'label'   => __('sogetrel.user.passwork._search.label_1'),
                'live_search' => true,
            ])@endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.wants_to_work_with.",
                'values' => [
                    'linky'                            => __('passwork.passwork.sogetrel.jobs.linky'),
                    'gazpar'                           => __('passwork.passwork.sogetrel.jobs.gazpar'),
                    'erector_rigger_local_loop_cooper' => __('passwork.passwork.sogetrel.jobs.erector_rigger_local_loop_cooper'),
                    'subscriber_technician_d3'         => __('passwork.passwork.sogetrel.jobs.subscriber_technician_d3'),
                    'local_loop'                       => __('passwork.passwork.sogetrel.jobs.local_loop'),
                    'erector_rigger_d2'                => __('passwork.passwork.sogetrel.jobs.erector_rigger_d2'),
                    'optic_fiber'                      => __('passwork.passwork.sogetrel.jobs.optic_fiber'),
                    'optic_welder'                     => __('passwork.passwork.sogetrel.jobs.optic_welder'),
                    'ftth'                             => __('passwork.passwork.sogetrel.jobs.ftth'),
                    'optical_network_maintenance'      => __('passwork.passwork.sogetrel.jobs.optical_network_maintenance'),
                    'cpe_technician'                   => __('passwork.passwork.sogetrel.jobs.cpe_technician'),
                    'erector_rigger_radio'             => __('passwork.passwork.sogetrel.jobs.erector_rigger_radio'),
                    'electric_vehicle_charging_stations' => __('passwork.passwork.sogetrel.jobs.electric_vehicle_charging_stations'),
                    'technicien_cavi'                  => __('passwork.passwork.sogetrel.jobs.technicien_cavi'),
                ],
                'value'  => request()->input('search.wants_to_work_with'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_2') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'    => "select",
                'multiple' => true,
                'name'    => "search.has_worked_with_in_engineering_computer.",
                'value'   => request()->input('search.has_worked_with_in_engineering_computer'),
                'values'   => [
                    'installation_and_maintenance_operations'   => __('sogetrel.user.passwork._search.installation_and_maintenance_operations'),
                    'diagnosis_and_troubleshooting'   => __('sogetrel.user.passwork._search.diagnosis_and_troubleshooting'),
                ],
                'label'   => __('sogetrel.user.passwork._search.engineering_computer_type'),
                'live_search' => true,
            ])@endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'    => "select",
                'multiple' => true,
                'name'    => "search.has_worked_with_in_technicien_cavi.",
                'value'   => request()->input('search.has_worked_with_in_technicien_cavi'),
                'values'   => [
                    'network_parameters'   => __('sogetrel.user.passwork._search.network_parameters'),
                    'parameters_active_equipment'   => __('sogetrel.user.passwork._search.parameters_active_equipment'),
                    'installation_and_parameter_of_motiring_software' => __('sogetrel.user.passwork._search.installation_and_parameter_of_motiring_software'),
                    'post_of_cable_cpa'     => __('sogetrel.user.passwork._search.post_of_cable_cpa'),
                    'terminals_cfa' => __('sogetrel.user.passwork._search.terminals_cfa'),
                    'post_camera'    => __('sogetrel.user.passwork._search.post_camera'),
                    'post_material'    => __('sogetrel.user.passwork._search.post_material')
                ],
                'label'   => __('sogetrel.user.passwork._search.technicien_cavi_type'),
                'live_search' => true,
            ])@endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.has_worked_with_in_civil_engineering.",
                'values' => [
                    'office_studies' => __('passwork.passwork.sogetrel.civil_engineer.office_studies'),
                    'vrd' => __('passwork.passwork.sogetrel.civil_engineer.vrd'),
                    'repair' => __('passwork.passwork.sogetrel.civil_engineer.repair'),
                    'posts_with_auger' => __('passwork.passwork.sogetrel.civil_engineer.posts_with_auger'),
                    'posts_with_hands' => __('passwork.passwork.sogetrel.civil_engineer.posts_with_hands'),
                    'street_cabinets' => __('passwork.passwork.sogetrel.civil_engineer.street_cabinets'),
                    'telecom_room' => __('passwork.passwork.sogetrel.civil_engineer.telecom_room'),
                    'trenchless_networks' => __('passwork.passwork.sogetrel.civil_engineer.trenchless_networks'),
                    'management_procedures' => __('passwork.passwork.sogetrel.civil_engineer.management_procedures')
                ],
                'value'  => request()->input('search.has_worked_with_in_civil_engineering'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_3') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.has_worked_with_in_engineering_office.",
                'values' => [
                    'study_manager'    => __('passwork.passwork.sogetrel.jobs.study_manager'),
                    'qgis' => __('passwork.passwork.sogetrel.jobs.qgis'),
                    'gaia' => __('passwork.passwork.sogetrel.jobs.gaia'),
                    'ipon_geofibre' => __('passwork.passwork.sogetrel.jobs.ipon_geofibre'),
                    'kheops' => __('passwork.passwork.sogetrel.jobs.kheops'),
                    'netgeo' => __('passwork.passwork.sogetrel.jobs.netgeo'),
                    'drawer_drafter' => __('passwork.passwork.sogetrel.jobs.drawer_drafter'),
                    'exe' => __('passwork.passwork.sogetrel.jobs.exe'),
                    'grace_thd' => __('passwork.passwork.sogetrel.jobs.grace_thd'),
                    'aerial_studies' => __('passwork.passwork.sogetrel.jobs.aerial_studies'),
                    'gc_studies' => __('passwork.passwork.sogetrel.jobs.gc_studies'),
                    'security_studies' => __('passwork.passwork.sogetrel.jobs.security_studies'),
                    'gcblo_owf' => __('passwork.passwork.sogetrel.jobs.gcblo_owf'),
                    'telecom_picketer' => __('passwork.passwork.sogetrel.jobs.telecom_picketer'),
                ],
                'value'  => request()->input('search.has_worked_with_in_engineering_office')
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_4') }}
                @endslot
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.department.",
                'values' => department()::options(),
                'value'  => request()->input('search.department'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_5') }}
                @endslot
            @endcomponent
        </div>

         <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.headquarters_department.",
                'values' => department()::inseeCodesOptions(),
                'value'  => request()->input('search.headquarters_department'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_6') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.of_operational_direction.",
                'values' => enterprise('SOGETREL')->children->pluck('name', 'id'),
                'value'  => request()->input('search.of_operational_direction'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_7') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "select",
                'multiple' => true,
                'name'   => "search.region.",
                'values' => region()::options(),
                'value'  => request()->input('search.region'),
                'live_search' => true,
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_8') }}
                @endslot
            @endcomponent
        </div>

        {{-- @todo reactivate when we find a way to filter on the JSON column
            <div class="col-md-3">
            @component('components.form.group', [
                'type'    => "select",
                'name'    => "search.employees",
                'value'   => request()->input('search.employees'),
                'values'  => [1 => "Oui", 0 => "Non"],
                'label'   => "Salariés",
            ])@endcomponent
        </div>
        --}}

    </div>
    <div class="row">
        <div class="col-md-3">
            @component('components.form.group', [
                'type'    => "select",
                'name'    => "search.flag_contacted",
                'value'   => request()->input('search.flag_contacted'),
                'values'  => [1 => __('sogetrel.user.passwork._search.yes'), 0 => __('sogetrel.user.passwork._search.no')],
                'label'   => __('sogetrel.user.passwork._search.contacted'),
            ])@endcomponent
        </div>

        <div class="col-md-3">
            @component('components.form.group', [
                'type'    => "select",
                'name'    => "search.status.",
                'multiple' => true,
                'value'   => request()->input('search.status'),
                'values'  => array_trans(array_mirror(sogetrel_passwork()::getAvailableStatuses()), 'user.statuses.'),
                'label'   => __('sogetrel.user.passwork._search.status'),
            ])@endcomponent
        </div>

        <div class="col-md-3">
            @component('components.form.group', [
                'type'    => "select",
                'name'    => "search.flag_parking",
                'value'   => request()->input('search.flag_parking'),
                'values'  => [1 => "Oui", 0 => "Non"],
                'label'   => __('sogetrel.user.passwork._search.parking'),
            ])@endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "text",
                'name'   => "search.name",
                'value'  => request()->input('search.name'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_9') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "text",
                'name'   => "search.enterprise",
                'value'  => request()->input('search.enterprise'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_10') }}
                @endslot
            @endcomponent
        </div>
        <div class="col-md-3">
            @component('components.form.group', [
                'type'   => "text",
                'name'   => "search.identification_number",
                'value'  => request()->input('search.identification_number'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search.label_11') }}
                @endslot
            @endcomponent
        </div>
    </div>

    <hr>
    <div class="text-right mb-2">
        @section('form-buttons')
            @if (request()->input('search'))
                <a href="#" data-toggle="modal" data-target="#save_search" type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="mr-3 fa fa-envelope"></i> {{ __('sogetrel.user.passwork._search.save_search') }}
                </a>
            @endif

            @if (auth()->user()->passworkSavedSearches()->count() > 0)
                @button(__('sogetrel.user.passwork._search.saved_searches')."|icon:list|color:secondary|outline|sm|href:".route('sogetrel.saved_search.index'))
            @endif

            @can('export', sogetrel_passwork())
                @button(__('sogetrel.user.passwork._search.export')."|icon:file-export|color:secondary|outline|sm|href:".route('sogetrel.passwork.export')."?".http_build_query(['search' => (array) request()->input('search')]))
            @endcan
            @button(__('sogetrel.user.passwork._search.reintialize_search')."|icon:sync|color:secondary|outline|sm|href:".route('sogetrel.passwork.index')."?reset")
            @button(__('sogetrel.user.passwork._search.search')."|type:submit|icon:search|color:primary|outline|sm")
        @show
    </div>
    @include('sogetrel.user.passwork.modals._saved_search')
</form>
