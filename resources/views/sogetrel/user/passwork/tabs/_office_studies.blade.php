<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._office_studies.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'study_manager.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.study_manager.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'study_manager.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'study_manager.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>

<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._office_studies.label_1') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'drawer_drafter.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.drawer_drafter.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'drawer_drafter.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'drawer_drafter.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>

<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._office_studies.label_2') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'telecom_picketer.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.telecom_picketer.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'telecom_picketer.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'telecom_picketer.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>

<ul>
    <li>
        @lang('passwork.passwork.sogetrel.telecom_picketer.other_experience_label')
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'telecom_picketer.other_experience', [])) as $experience)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.telecom_picketer.other_experience.{$experience}")</b>
                </li>
            @empty
                <b>n/a</b>
            @endforelse
        </ul>
    </li>
</ul>

<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._office_studies.label_3') }}</h4>

<ul>
    <li>
        @lang('passwork.passwork.sogetrel.engineering_office_software.dao_software_label')
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'engineering_office_software.dao_software', [])) as $software)
                @if($software)
                    <li>
                        <b>@lang("passwork.passwork.sogetrel.engineering_office_software.dao_software.{$software}")</b>
                    </li>
                @else
                    <b class="text-muted">n/a</b>
                @endif
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
</ul>

<ul>
    <li>
    @lang('passwork.passwork.sogetrel.engineering_office_software.sig_software_label')
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'engineering_office_software.sig_software', [])) as $software)
                @if($software)
                    <li>
                        <b>@lang("passwork.passwork.sogetrel.engineering_office_software.sig_software.{$software}")</b>
                    </li>
                @else
                    <b class="text-muted">n/a</b>
                @endif
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
</ul>

<ul>
    <li>
    @lang('passwork.passwork.sogetrel.engineering_office_software.business_software_label')
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'engineering_office_software.business_software', [])) as $software)
                @if($software)
                    <li>
                        <b>@lang("passwork.passwork.sogetrel.engineering_office_software.business_software.{$software}")</b>
                    </li>
                @else
                    <b class="text-muted">n/a</b>
                @endif
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
</ul>
