<h4>{{ __('sogetrel.user.passwork.jobs._local_loop.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.level')
        </span>
        @if (array_get($passwork->data, 'local_loop.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'local_loop.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'local_loop.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'local_loop.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.reads_blueprints', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.reads_blueprints')
        </span>
        @if (array_get($passwork->data, 'local_loop.reads_blueprints', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.reads_blueprints', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.understands_cable_blueprint', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.understands_cable_blueprint')
        </span>
        @if (array_get($passwork->data, 'local_loop.understands_cable_blueprint', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.understands_cable_blueprint', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.differenciates_cables', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.differenciates_cables')
        </span>
        @if (array_get($passwork->data, 'local_loop.differenciates_cables', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.differenciates_cables', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.cable_connection_rules', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.cable_connection_rules')
        </span>
        @if (array_get($passwork->data, 'local_loop.cable_connection_rules', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.cable_connection_rules', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.electrical_measures', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.electrical_measures')
        </span>
        @if (array_get($passwork->data, 'local_loop.electrical_measures', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.electrical_measures', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'local_loop.optical_measures', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.local_loop.optical_measures')
        </span>
        @if (array_get($passwork->data, 'local_loop.optical_measures', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.yes') }}</span>
        @elseif (array_get($passwork->data, 'local_loop.optical_measures', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._local_loop.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
