<h4>{{ __('sogetrel.user.passwork.jobs._optic.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'optic.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.level')
        </span>
        @if (array_get($passwork->data, 'optic.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'optic.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.understands_measurment_curve', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.understands_measurment_curve')
        </span>
        @if (array_get($passwork->data, 'optic.understands_measurment_curve', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic.understands_measurment_curve', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.understands_cable_blueprint', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.understands_cable_blueprint')
        </span>
        @if (array_get($passwork->data, 'optic.understands_cable_blueprint', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic.understands_cable_blueprint', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.differenciates_cables', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.differenciates_cables')
        </span>
        @if (array_get($passwork->data, 'optic.differenciates_cables', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic.differenciates_cables', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.understance_optic_fiber_basics', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.understance_optic_fiber_basics')
        </span>
        @if (array_get($passwork->data, 'optic.understance_optic_fiber_basics', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif(array_get($passwork->data, 'optic.understance_optic_fiber_basics', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.masters_connection_tools', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.masters_connection_tools')
        </span>
        @if (array_get($passwork->data, 'optic.masters_connection_tools', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic.masters_connection_tools', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic.masters_measuring_tools', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic.masters_measuring_tools')
        </span>
        @if (array_get($passwork->data, 'optic.masters_measuring_tools', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic.masters_measuring_tools', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
