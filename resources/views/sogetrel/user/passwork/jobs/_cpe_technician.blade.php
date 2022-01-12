<h4>{{ __('sogetrel.user.passwork.jobs._cpe_technician.technician_intervation') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'cpe_technician.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.cpe_technician.level')
        </span>
        @if (array_get($passwork->data, 'cpe_technician.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'cpe_technician.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'cpe_technician.installation_rules_commissioning', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.cpe_technician.installation_rules_commissioning')
        </span>
        @if (array_get($passwork->data, 'cpe_technician.installation_rules_commissioning', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'cpe_technician.installation_rules_commissioning', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'cpe_technician.wiring_installation_commissioning', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.cpe_technician.wiring_installation_commissioning')
        </span>
        @if (array_get($passwork->data, 'cpe_technician.wiring_installation_commissioning', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'cpe_technician.wiring_installation_commissioning', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'cpe_technician.measurements_with_specific_devices', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.cpe_technician.measurements_with_specific_devices')
        </span>
        @if (array_get($passwork->data, 'cpe_technician.measurements_with_specific_devices', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'cpe_technician.measurements_with_specific_devices', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._cpe_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
