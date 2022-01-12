<h4>{{ __('sogetrel.user.passwork.jobs.technicien_cavi.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.network_parameters', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.network_parameters')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.network_parameters', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.network_parameters', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.parameters_active_equipment', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.parameters_active_equipment')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.parameters_active_equipment', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.parameters_active_equipment', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.installation_and_parameter_of_motiring_software', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.installation_and_parameter_of_motiring_software')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.installation_and_parameter_of_motiring_software', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.installation_and_parameter_of_motiring_software', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.post_of_cable_cpa', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.post_of_cable_cpa')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.post_of_cable_cpa', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.post_of_cable_cpa', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.terminals_cfa', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.terminals_cfa')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.terminals_cfa', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.terminals_cfa', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.post_camera', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.post_camera')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.post_camera', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.post_camera', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'technicien_cavi.post_material', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.technicien_cavi.post_material')
        </span>
        @if (array_get($passwork->data, 'technicien_cavi.post_material', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.yes') }}</span>
        @elseif (array_get($passwork->data, 'technicien_cavi.post_material', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.technicien_cavi.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
