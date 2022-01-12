<ul> 
    <li>
        <span {!! array_get($passwork->data, 'electrician', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.electrician')
        </span>
        @if (array_get($passwork->data, 'electrician', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif(array_get($passwork->data, 'electrician', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'multi_activities', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.multi_activities')
        </span>
        @if (array_get($passwork->data, 'multi_activities', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{  __('sogetrel.user.passwork.tabs._general_informations.yes')}}</span>
        @elseif (array_get($passwork->data, 'multi_activities', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'engineering_office', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.engineering_office')
        </span>
        @if (array_get($passwork->data, 'engineering_office', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif(array_get($passwork->data, 'engineering_office', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{__('sogetrel.user.passwork.tabs._general_informations.no')  }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
     <li>
        <span {!! array_get($passwork->data, 'cavi', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.technicien_cavi')
        </span>
        @if (array_get($passwork->data, 'cavi', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif(array_get($passwork->data, 'cavi', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{__('sogetrel.user.passwork.tabs._general_informations.no')  }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'engineering_computer_mib', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.engineering_computer_mib')
        </span>
        @if (array_get($passwork->data, 'engineering_computer_mib', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif(array_get($passwork->data, 'engineering_computer_mib', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{__('sogetrel.user.passwork.tabs._general_informations.no')  }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'civil_engineering', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.civil_engineering')
        </span>
        @if (array_get($passwork->data, 'civil_engineering', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif(array_get($passwork->data, 'civil_engineering', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <hr>
    <li>
        @lang('passwork.passwork.sogetrel.years_of_experience')
        <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'years_of_experience'))</b>
    </li>
    <li>
        <span {!! array_get($passwork->data, 'independant', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.independant')
        </span>
        @if (array_get($passwork->data, 'independant', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif (array_get($passwork->data, 'independant', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        @lang('passwork.passwork.sogetrel.phone')
        <b><a href="tel:{{ $phone = array_get($passwork->data, 'phone', false) }}">{{ $phone }}</a></b>
    </li>
    <li>
        @lang('user.user.email') :
        <b><a href="mailto:{{ $passwork->user->email }}">{{ $passwork->user->email }}</a></b>
    </li>
    <li>
        <span {!! array_get($passwork->data, 'availability', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.availability')
        </span>
        @if (array_get($passwork->data, 'availability', false))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'availability', false))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    <li>
        <span {!! array_get($passwork->data, 'wants_to_be_independant', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.wants_to_be_independant')
        </span>
        @if (array_get($passwork->data, 'wants_to_be_independant', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.yes') }}</span>
        @elseif (array_get($passwork->data, 'wants_to_be_independant', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._general_informations.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'enterprise_name') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.enterprise_name')
        </span>
        <b>
            @if(array_get($passwork->data, 'enterprise_name'))
                {{ array_get($passwork->data, 'enterprise_name') }}
            @else
                <span class="text-muted"> n/a </span>
            @endif
        </b>
    </li>

    <li>
        <span {!! array_get($passwork->data, 'enterprise_postal_code') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.enterprise_postal_code')
        </span>
        <b>
            @if(array_get($passwork->data, 'enterprise_postal_code'))
                {{ array_get($passwork->data, 'enterprise_postal_code') }}
            @else
                <span class="text-muted"> n/a </span>
            @endif
        </b>
    </li>
    <li>
        <span {!! array_get($passwork->data, 'enterprise_number_of_employees') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.enterprise_number_of_employees')
        </span>
        <b>
            @if (max(array_get($passwork->data, 'enterprise_number_of_employees') ?? 0, 0))
                {{ max(array_get($passwork->data, 'enterprise_number_of_employees') ?? 0, 0) }}
            @else
                <span class="text-muted"> n/a </span>
            @endif
        </b>
    </li>
    <li>
        <span {!! array_get($passwork->data, 'years_of_experience_as_independant') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.years_of_experience_as_independant')
        </span>
        @if (array_get($passwork->data, 'years_of_experience_as_independant'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'years_of_experience_as_independant'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>

    @if(auth()->user()->isSupport())
        <li>
            <span {!! array_get($passwork->data, 'acquisition', false) == null? 'class="text-muted"' : '' !!} >
                @lang('passwork.passwork.sogetrel.acquisition')
            </span>
            @if (array_get($passwork->data, 'acquisition', false))
                <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'acquisition', false))</b>
            @else
                <b class="text-muted">n/a</b>
            @endif
        </li>
    @endif

    <li>
        <span {!! array_get($passwork->data, 'website', false) == null? 'class="text-muted"' : '' !!} >
                @lang('passwork.passwork.sogetrel.website')
        </span>
        @if (array_get($passwork->data, 'website', false))
            <b>{{ array_get($passwork->data, 'website', false) }}</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <hr>
    <li>
        @lang('passwork.passwork.sogetrel.has_worked_with') ?
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'has_worked_with', [])) as $work)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.{$work}_label")</b>
                </li>
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
    <li>
        <span {!! array_get($passwork->data, 'wants_to_work_with', []) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.wants_to_work_with')
        </span>
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'wants_to_work_with', [])) as $work)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.{$work}_label")</b>
                </li>
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
    <hr>
    <li>
        <span {!! array_get($passwork->data, 'has_worked_with_in_engineering_office', []) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.has_worked_with_in_engineering_office')
        </span>
        <ul>
            @forelse (array_keys(array_get($passwork->data, 'has_worked_with_in_engineering_office', [])) as $job)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.{$job}_label")</b>
                </li>
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
    <hr>
    <li>
        <span {!! array_get($passwork->data, 'has_worked_with_in_civil_engineering', []) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.has_worked_with_in_civil_engineering')
        </span>
        <ul>
            @forelse (array_get($passwork->data, 'has_worked_with_in_civil_engineering', []) as $job)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.{$job}_label")</b>
                </li>
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
    <hr>
    <li>
        @lang('passwork.passwork.sogetrel.other_clearances_label')
        <ul>
            @forelse (array_get($passwork->data, 'other_clearances', []) as $work)
                <li>
                    <b>@lang("passwork.passwork.sogetrel.other_clearances.{$work}")</b>
                </li>
            @empty
                <b class="text-muted">n/a</b>
            @endforelse
        </ul>
    </li>
</ul>

<hr>

<ul>
    <li>
        @lang('passwork.passwork.sogetrel.departments')

        <ul>
            {{ implode(',', $passwork->departments->pluck('display_name')->toArray()) }}
        </ul>
    </li>
</ul>
