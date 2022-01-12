<hr>
<h4>{{ __('sogetrel.user.passwork.tabs._civil_engineering.title') }} </h4>

<ul>
    <li>
        <span {{ attr_unless(in_array('office_studies', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_1') }}
        </span>
        <b> @if(in_array('office_studies', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('vrd', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_2') }}
        </span>
        <b> @if(in_array('vrd', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('repair', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_3') }}
        </span>
        <b> @if(in_array('repair', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('posts_with_auger', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_4') }}
        </span>
        <b> @if(in_array('posts_with_auger', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('posts_with_hands', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_5') }}
        </span>
        <b> @if(in_array('posts_with_hands', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('street_cabinets', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_6') }}
        </span>
        <b> @if(in_array('street_cabinets', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('telecom_room', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_7') }}
        </span>
        <b> @if(in_array('telecom_room', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('trenchless_networks', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_8') }}
        </span>
        <b> @if(in_array('trenchless_networks', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>

    <li>
        <span {{ attr_unless(in_array('management_procedures', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])), ['class' => "text-muted"]) }} >
            {{ __('sogetrel.user.passwork.tabs._civil_engineering.label_9') }}
        </span>
        <b> @if(in_array('management_procedures', array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])))
                <span class="label label-success"><i class="fa fa-check"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.yes') }}</span>
            @else
                <span class="label label-danger"><i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.tabs._civil_engineering.no') }}</span>
            @endif
        </b>
    </li>
</ul>
