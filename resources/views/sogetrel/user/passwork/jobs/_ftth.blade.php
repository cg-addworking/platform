<h4>{{ __('sogetrel.user.passwork.jobs._ftth.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'ftth.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.level')
        </span>
        @if (array_get($passwork->data, 'ftth.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'ftth.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.read_electric_blueprints', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.read_electric_blueprints')
        </span>
        @if (array_get($passwork->data, 'ftth.read_electric_blueprints', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif(array_get($passwork->data, 'ftth.read_electric_blueprints', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.read_wiring_blueprints', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.read_wiring_blueprints')
        </span>
        @if (array_get($passwork->data, 'ftth.read_wiring_blueprints', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif (array_get($passwork->data, 'ftth.read_wiring_blueprints', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.differentiate_cables', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.differentiate_cables')
        </span>
        @if (array_get($passwork->data, 'ftth.differentiate_cables', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif(array_get($passwork->data, 'ftth.differentiate_cables', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.cable_connection_rules', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.cable_connection_rules')
        </span>
        @if (array_get($passwork->data, 'ftth.cable_connection_rules', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif (array_get($passwork->data, 'ftth.cable_connection_rules', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.electrical_measures', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.electrical_measures')
        </span>
        @if (array_get($passwork->data, 'ftth.electrical_measures', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif (array_get($passwork->data, 'ftth.electrical_measures', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'ftth.optical_measures', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.ftth.optical_measures')
        </span>
        @if (array_get($passwork->data, 'ftth.optical_measures', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._ftth.yes') }}</span>
        @elseif (array_get($passwork->data, 'ftth.optical_measures', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._ftth.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
