<h4>{{ __('sogetrel.user.passwork.jobs.engineering_computer.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'engineering_computer.installation_and_maintenance_operations', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.engineering_computer.installation_and_maintenance_operations')
        </span>
        @if (array_get($passwork->data, 'engineering_computer.installation_and_maintenance_operations', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.engineering_computer.yes') }}</span>
        @elseif (array_get($passwork->data, 'engineering_computer.installation_and_maintenance_operations', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.engineering_computer.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'engineering_computer.diagnosis_and_troubleshooting', false) == null? 'class="text-muted"' : '' !!} >
            @lang('sogetrel.user.passwork.jobs.engineering_computer.diagnosis_and_troubleshooting')
        </span>
        @if (array_get($passwork->data, 'engineering_computer.diagnosis_and_troubleshooting', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.jobs.engineering_computer.yes') }}</span>
        @elseif (array_get($passwork->data, 'engineering_computer.diagnosis_and_troubleshooting', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.jobs.engineering_computer.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
