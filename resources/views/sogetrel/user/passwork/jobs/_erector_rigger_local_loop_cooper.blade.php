<h4>{{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.level')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_local_loop_cooper.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_local_loop_cooper.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.reads_blueprints', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.reads_blueprints')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.reads_blueprints', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_local_loop_cooper.reads_blueprints', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.understands_cable_blueprint', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.understands_cable_blueprint')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.understands_cable_blueprint', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_local_loop_cooper.understands_cable_blueprint', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.differenciates_cables', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.differenciates_cables')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.differenciates_cables', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_local_loop_cooper.differenciates_cables', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.cable_connection_rules', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.cable_connection_rules')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.cable_connection_rules', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_local_loop_cooper.cable_connection_rules', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_local_loop_cooper.electrical_measures', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_local_loop_cooper.electrical_measures')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_local_loop_cooper.electrical_measures', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.yes') }}</span>
        @elseif (array_get($passwork->data, 'erector_rigger_local_loop_cooper.electrical_measures', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
