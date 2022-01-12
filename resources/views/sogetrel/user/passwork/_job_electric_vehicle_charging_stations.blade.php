<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.electric_vehicle_charging_stations.level",
            'value'  => array_get($passwork->data, 'electric_vehicle_charging_stations.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.expert'),
            ]
        ])
            @slot('label')
                @lang('passwork.passwork.sogetrel.electric_vehicle_charging_stations.level')
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.help_1') }}
                {{ __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.help_2') }}
                {{ __('sogetrel.user.passwork._job_electric_vehicle_charging_stations.help_3') }}
            @endslot
        @endcomponent
    </div>
</div>

