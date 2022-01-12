<h4>{{ __('sogetrel.user.passwork.jobs._erector_rigger_d2.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_d2.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_d2.level')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_d2.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_d2.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'erector_rigger_d2.years_of_experience') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.erector_rigger_d2.years_of_experience')
        </span>
        @if (array_get($passwork->data, 'erector_rigger_d2.years_of_experience'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_d2.years_of_experience'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
