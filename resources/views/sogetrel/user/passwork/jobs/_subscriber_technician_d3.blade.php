<h4>{{ __('sogetrel.user.passwork.jobs._subscriber_technician_d3.title') }}</h4>

<ul>
    <li>
        <span {!! array_get($passwork->data, 'subscriber_technician_d3.level') == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.subscriber_technician_d3.level')
        </span>
        @if (array_get($passwork->data, 'subscriber_technician_d3.level'))
            <b>@lang('passwork.passwork.sogetrel.' . array_get($passwork->data, 'subscriber_technician_d3.level'))</b>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>
<hr>
