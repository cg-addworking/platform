<h4>{{ __('sogetrel.user.passwork.jobs._optic_welder.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.level')
        </span>
        @if (array_get($passwork->data, 'optic_welder.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'optic_welder.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.understands_cable_blueprint', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.understands_cable_blueprint')
        </span>
        @if (array_get($passwork->data, 'optic_welder.understands_cable_blueprint', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.understands_cable_blueprint', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.differenciates_cables', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.differenciates_cables')
        </span>

        @if (array_get($passwork->data, 'optic_welder.differenciates_cables', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.differenciates_cables', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.masters_optic_cable_rules', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.masters_optic_cable_rules')
        </span>
        @if (array_get($passwork->data, 'optic_welder.masters_optic_cable_rules', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.masters_optic_cable_rules', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.masters_welding', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.masters_welding')
        </span>
        @if (array_get($passwork->data, 'optic_welder.masters_welding', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.masters_welding', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.master_welder_tool', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.master_welder_tool')
        </span>
        @if (array_get($passwork->data, 'optic_welder.master_welder_tool', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.master_welder_tool', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.masters_measuring_tools', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.masters_measuring_tools')
        </span>
        @if (array_get($passwork->data, 'optic_welder.masters_measuring_tools', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.masters_measuring_tools', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optic_welder.masters_optic_measuring_tools', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optic_welder.masters_optic_measuring_tools')
        </span>
        @if (array_get($passwork->data, 'optic_welder.masters_optic_measuring_tools', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.yes') }}</span>
        @elseif (array_get($passwork->data, 'optic_welder.masters_optic_measuring_tools', false) === 0)
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optic_welder.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
