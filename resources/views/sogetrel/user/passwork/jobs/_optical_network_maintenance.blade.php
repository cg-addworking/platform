<h4>{{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'optical_network_maintenance.network_setting', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optical_network_maintenance.network_setting')
        </span>
        @if (array_get($passwork->data, 'optical_network_maintenance.network_setting', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.yes') }}</span>
        @elseif (array_get($passwork->data, 'optical_network_maintenance.network_setting', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optical_network_maintenance.configuration_of_active_equipment', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optical_network_maintenance.configuration_of_active_equipment')
        </span>
        @if (array_get($passwork->data, 'optical_network_maintenance.configuration_of_active_equipment', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.yes') }}</span>
        @elseif (array_get($passwork->data, 'optical_network_maintenance.configuration_of_active_equipment', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'optical_network_maintenance.configuration_of_the_physical_medium', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.optical_network_maintenance.configuration_of_the_physical_medium')
        </span>
        @if (array_get($passwork->data, 'optical_network_maintenance.configuration_of_the_physical_medium', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.yes') }}</span>
        @elseif (array_get($passwork->data, 'optical_network_maintenance.configuration_of_the_physical_medium', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs._optical_network_maintenance.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
