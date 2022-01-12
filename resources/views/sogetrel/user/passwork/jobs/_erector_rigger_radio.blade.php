<h4>{{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.level')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_radio.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.reads_blueprints') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.reads_blueprints')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.reads_blueprints', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.reads_blueprints', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.coaxial_connector_grounding_installation', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.coaxial_connector_grounding_installation')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.coaxial_connector_grounding_installation', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.coaxial_connector_grounding_installation', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.indoor_installation', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.indoor_installation')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.indoor_installation', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.indoor_installation', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.railway_environment_installation', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.railway_environment_installation')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.railway_environment_installation', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.railway_environment_installation', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.confidential_defense_empowerment', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.confidential_defense_empowerment')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.confidential_defense_empowerment', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.confidential_defense_empowerment', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.connection_radio_equipment')
            @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment', false) == null )
                <b class="text-muted">n/a</b>
            @endif
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.0', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.4g') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.1', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.5g') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.2', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.tetra') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.3', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.wifi') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.4', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.lora') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.5', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.gsm-r') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.connection_radio_equipment.6', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.other') }}</span>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.work_height_pylon_roof_water_tower', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.work_height_pylon_roof_water_tower')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.work_height_pylon_roof_water_tower', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_radio.work_height_pylon_roof_water_tower', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_radio.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.measure_tools', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.measure_tools')
            @if (array_get($passwork->data, 'erector_rigger_radio.measure_tools', false) == null )
                <b class="text-muted">n/a</b>
            @endif
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.measure_tools.0', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.optical') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.measure_tools.1', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.radio') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.measure_tools.2', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.pim') }}</span>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.operator', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.operator')
            @if (array_get($passwork->data, 'erector_rigger_radio.operator', false) == null )
                <b class="text-muted">n/a</b>
            @endif
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.operator.0', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.orange') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.operator.1', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.bouygues') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.operator.2', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.sfr') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.operator.3', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.free') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.operator.4', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.other') }}</span>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_radio.equipment', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_radio.equipment')
            @if (array_get($passwork->data, 'erector_rigger_radio.equipment', false) == null )
                <b class="text-muted">n/a</b>
            @endif
        </span>
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.0', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.huawei') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.1', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.ericsson') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.2', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.nokia') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.3', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.comscope') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.4', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.zte') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.5', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.kapsch') }}</span>
        @endif
        @if (array_get($passwork->data, 'erector_rigger_radio.equipment.6', false))
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('passwork.passwork.sogetrel.erector_rigger_radio.other') }}</span>
        @endif
    </li>
</ul>
