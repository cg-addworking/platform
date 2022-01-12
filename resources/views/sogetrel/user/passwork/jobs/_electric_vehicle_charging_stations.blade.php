<h4>{{ __('sogetrel.user.passwork.jobs._electric_vehicle_charging_stations.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'electric_vehicle_charging_stations.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.electric_vehicle_charging_stations.level')
        </span>
        @if (array_get($passwork->data, 'electric_vehicle_charging_stations.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'electric_vehicle_charging_stations.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
