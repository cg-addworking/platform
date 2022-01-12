<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._electrician_technician.title') }}</h4>

<ul>
    <li>
        <span {!! (array_get($passwork->data, 'gazpar.trained', false)) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.gazpar.trained')
        </span>
        @if (array_get($passwork->data, 'gazpar.trained', false) === "yes")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'gazpar.trained', false) === "no")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.no') }}</span>
        @elseif(array_get($passwork->data, 'gazpar.trained', false) === "willing_to_learn")
            <span class="label label-warning"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.willing_to_learn') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>

<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_1') }}</h4>

<ul>
    <li>
        <span {!! (array_get($passwork->data, 'linky.trained', false)) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.linky.trained')
        </span>
        @if (array_get($passwork->data, 'linky.trained', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.yes') }}</span>
        @elseif(array_get($passwork->data, 'linky.trained', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.no') }}</span>
        @elseif(array_get($passwork->data, 'linky.trained', false) == "willing_to_learn")
            <span><b> {{ __('sogetrel.user.passwork.tabs._electrician_technician.willing_to_learn_2') }}</b></span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'linky.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.linky.level')
        </span>
        @if (array_get($passwork->data, 'linky.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'linky.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! (array_get($passwork->data, 'linky.deposit', false)) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.linky.deposit')
        </span>
        @if (array_get($passwork->data, 'linky.deposit', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'linky.deposit', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! (array_get($passwork->data, 'linky.programming', false)) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.linky.programming')
        </span>
        @if (array_get($passwork->data, 'linky.programming', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.yes') }}</span>
        @elseif(array_get($passwork->data, 'linky.programming', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'linky.maintenance', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.linky.maintenance')
        </span>
        @if (array_get($passwork->data, 'linky.maintenance', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.yes') }}</span>
        @elseif (array_get($passwork->data, 'linky.maintenance', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._electrician_technician.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    <br />
    </li>
    <li>
        <h3 class="text-muted" >{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_2') }}</h3>
        @include('sogetrel.user.passwork.jobs._erector_rigger_local_loop_cooper', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._subscriber_technician_d3', ['passwork' => $passwork])

    </li>

    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_3') }}</h3>
        @include('sogetrel.user.passwork.jobs._local_loop', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._erector_rigger_d2', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._optic', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._ftth', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._optic_welder', ['passwork' => $passwork])
        @include('sogetrel.user.passwork.jobs._optical_network_maintenance', ['passwork' => $passwork])
    </li>

    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_4') }}</h3>
        @include('sogetrel.user.passwork.jobs._cpe_technician', ['passwork' => $passwork])
    </li>

    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.radio') }}</h3>
        @include('sogetrel.user.passwork.jobs._erector_rigger_radio', ['passwork' => $passwork])
    </li>

    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_5') }}</h3>
        @include('sogetrel.user.passwork.jobs._electric_vehicle_charging_stations', ['passwork' => $passwork])
    </li>
    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_6') }}</h3>
        @include('sogetrel.user.passwork.jobs._technicien_cavi', ['passwork' => $passwork])
    </li>
    <li>
        <h3 class="text-muted">{{ __('sogetrel.user.passwork.tabs._electrician_technician.label_7') }}</h3>
        @include('sogetrel.user.passwork.jobs._engineering_computer', ['passwork' => $passwork])
    </li>
</ul>
