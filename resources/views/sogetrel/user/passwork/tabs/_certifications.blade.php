<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._certifications.title') }}</h4>
<ul>
    @if ($electrical_clearances = array_get($passwork->data, 'optic_welder.electrical_clearances'))
        @forelse ($electrical_clearances as $item)
            @if ($item == "other")
                @if ($electrical_clearances_other = array_get($passwork->data, 'optic_welder.electrical_clearances_other'))
                    <li>
                        @lang('passwork.passwork.sogetrel.other_clearances.other') : <b>{{ $electrical_clearances_other }}</b>
                    </li>
                @endif
            @elseif ($item != "other")
                <li>
                    @lang("passwork.passwork.sogetrel.{$item}")
                </li>
            @endif
        @empty
            <b class="text-muted">n/a</b>
        @endforelse

    @elseif ($electrical_clearances = array_get($passwork->data, 'electrical_clearances'))
        @forelse ($electrical_clearances as $item)
            @if ($item == "other")
                @if ($electrical_clearances_other = array_get($passwork->data, 'electrical_clearances_other'))
                    <li>
                        @lang('passwork.passwork.sogetrel.other_clearances.other') : <b>{{ $electrical_clearances_other }}</b>
                    </li>
                @endif
            @elseif ($item != "other")
                <li>
                    @lang("passwork.passwork.sogetrel.{$item}")
                </li>
            @endif
        @empty
            <b class="text-muted">n/a</b>
        @endforelse

    @else
        <li>
             <span {!! $electrical_clearances == null? 'class="text-muted"' : '' !!} >
                @lang('passwork.passwork.sogetrel.optic_welder.electrical_clearances')
            </span>
            <b class="text-muted">n/a</b>
        </li>
    @endif
</ul>
<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._certifications.title_qualification') }}</h4>

<ul>
    @if ($qualifications = array_get($passwork->data, 'qualifications', false))
        <li>
            @lang('passwork.passwork.sogetrel.qualifications')
            <b>{{ $qualifications }}</b>
        </li>
    @endif
</ul>
<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._certifications.other_abilities') }}</h4>
<ul>
    @if ($workHeight = array_get($passwork->data, 'work_height_ability', false))
        <li>
            <span {!! $workHeight ? '' : 'class="text-muted"'!!} >
                @lang('sogetrel.user.passwork._tab3.label_3')
            </span>
            @if ($workHeight)
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    @endif

    @if ($workWithRopes = array_get($passwork->data, 'work_with_ropes', false))
        <li>
            <span {!! $workWithRopes ? '' : 'class="text-muted"'!!} >
                @lang('sogetrel.user.passwork._tab3.label_4')
            </span>
            @if ($workWithRopes)
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    @endif
</ul>

@if ($otherClearances = array_get($passwork->data, 'other_clearances', false))
<hr>
    <ul>
        <li>
            <span {!! in_array('ss4', $otherClearances, false)? '' : 'class="text-muted"'!!} >
                @lang('passwork.passwork.sogetrel.other_clearances.ss4')
            </span>
            @if (in_array('ss4', $otherClearances, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>

        <li>
            <span {!! in_array('aipr', $otherClearances, false)? '': 'class="text-muted"' !!} >
                @lang('passwork.passwork.sogetrel.other_clearances.aipr')
            </span>
            @if (in_array('aipr', $otherClearances, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>

        <li>
            <span {!! array_get($passwork->data, 'precision_clearances_other', false)? '' : 'class="text-muted"'!!} >
                @lang('passwork.passwork.sogetrel.other_clearances.other') :
            </span>
            <b> {!! array_get($passwork->data, 'precision_clearances_other', false)
                ?? '<span class="text-muted">n/a</span>' !!} </b>
        </li>
    </ul>
@endif

@if ($cacesAbility = array_get($passwork->data, 'caces_ability', false))
<hr>
    <ul>
        <li>
            <span {!! in_array('r436', $cacesAbility, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.r436') }}
            </span>
            @if (in_array('r436', $cacesAbility, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('r482', $cacesAbility, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.r482') }}
            </span>
            @if (in_array('r482', $cacesAbility, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('r489', $cacesAbility, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.r489') }}
            </span>
            @if (in_array('r489', $cacesAbility, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>

        <li>
            <span {!! array_get($passwork->data, 'caces_ability_other', false)? '' : 'class="text-muted"'!!} >
                @lang('passwork.passwork.sogetrel.other_clearances.other') :
            </span>
            <b> {!! array_get($passwork->data, 'caces_ability_other', false)
                ?? '<span class="text-muted">n/a</span>' !!} </b>
        </li>
    </ul>
@endif

@if ($licenses = array_get($passwork->data, 'licenses', false))
<hr>
    <ul>
        <li>
            <span {!! in_array('b', $licenses, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.b') }}
            </span>
            @if (in_array('b', $licenses, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('c', $licenses, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.c') }}
            </span>
            @if (in_array('c', $licenses, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('e', $licenses, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.e') }}
            </span>
            @if (in_array('e', $licenses, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
@if ($software_supervision = array_get($passwork->data, 'software_supervision', false))
<hr>
<h5>{{ __('sogetrel.user.passwork._tab3.software_supervision') }}</h5>
    <ul>
        <li>
            <span {!! in_array('genetec', $software_supervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.genetec') }}
            </span>
            @if (in_array('genetec', $software_supervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('milestone', $software_supervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.milestone') }}
            </span>
            @if (in_array('milestone', $software_supervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('casd', $software_supervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.casd') }}
            </span>
            @if (in_array('casd', $software_supervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('flir', $software_supervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.flir') }}
            </span>
            @if (in_array('flir', $software_supervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
@if ($camera_mark = array_get($passwork->data, 'camera_mark', false))
<hr>
<h5>{{ __('sogetrel.user.passwork._tab3.camera_mark') }}</h5>
    <ul>
        <li>
            <span {!! in_array('axis', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.axis') }}
            </span>
            @if (in_array('axis', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('bosch', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.bosch') }}
            </span>
            @if (in_array('bosch', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('hanwah', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.hanwah') }}
            </span>
            @if (in_array('hanwah', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('hik', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.hik') }}
            </span>
            @if (in_array('hik', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
         <li>
            <span {!! in_array('dahua', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.dahua') }}
            </span>
            @if (in_array('dahua', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('flir', $camera_mark, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.flir') }}
            </span>
            @if (in_array('flir', $camera_mark, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
@if ($software_supervision_marks = array_get($passwork->data, 'software_supervision_marks', false))
<hr>
<h5>{{ __('sogetrel.user.passwork._tab3.software_supervision_marks') }}</h5>
    <ul>
        <li>
            <span {!! in_array('nedap', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.nedap') }}
            </span>
            @if (in_array('nedap', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('til', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.til') }}
            </span>
            @if (in_array('til', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('genetec', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.genetec') }}
            </span>
            @if (in_array('genetec', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('vanderbilt', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.vanderbilt') }}
            </span>
            @if (in_array('vanderbilt', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
         <li>
            <span {!! in_array('synchronic', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.synchronic') }}
            </span>
            @if (in_array('synchronic', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('alcea', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.alcea') }}
            </span>
            @if (in_array('alcea', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('honeywell', $software_supervision_marks, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.honeywell') }}
            </span>
            @if (in_array('honeywell', $software_supervision_marks, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
@if ($opportunities = array_get($passwork->data, 'opportunities', false))
<hr>
<h5>{{ __('sogetrel.user.passwork._tab3.opportunities') }}</h5>
    <ul>
        <li>
            <span {!! in_array('gallagher', $opportunities, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.gallagher') }}
            </span>
            @if (in_array('gallagher', $opportunities, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('ccure', $opportunities, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.ccure') }}
            </span>
            @if (in_array('ccure', $opportunities, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
@if ($hypervision = array_get($passwork->data, 'hypervision', false))
<hr>
<h5>{{ __('sogetrel.user.passwork._tab3.hypervision') }}</h5>
    <ul>
        <li>
            <span {!! in_array('prysm', $hypervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.prysm') }}
            </span>
            @if (in_array('prysm', $hypervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('saratec', $hypervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.saratec') }}
            </span>
            @if (in_array('saratec', $hypervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
        <li>
            <span {!! in_array('obs', $hypervision, false)? '' : 'class="text-muted"'!!} >
                {{ __('sogetrel.user.passwork._tab3.obs') }}
            </span>
            @if (in_array('obs', $hypervision, false))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
            @endif
        </li>
    </ul>
@endif
<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._certifications.other_authorizations') }}</h4>
<ul>
    <li>
        <span {!! array_get($passwork->data, 'rc_pro', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.rc_pro')
        </span>
        @if (array_get($passwork->data, 'rc_pro', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
        @elseif (array_get($passwork->data, 'rc_pro', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
    <li>
        <span {!! array_get($passwork->data, 'insurance', false) == null? 'class="text-muted"' : '' !!} >
            @lang('passwork.passwork.sogetrel.insurance')
        </span>
        @if (array_get($passwork->data, 'insurance', false) === "1")
            <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._certifications.yes') }}</span>
        @elseif (array_get($passwork->data, 'insurance', false) === "0")
            <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._certifications.no') }}</span>
        @else
            <b class="text-muted">n/a</b>
        @endif
    </li>
</ul>