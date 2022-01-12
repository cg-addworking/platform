<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.rc_pro",
            'value'    => array_get($passwork->data, 'rc_pro'),
            'values'   => [1 => __('sogetrel.user.passwork._tab4.yes'), 0 => __('sogetrel.user.passwork._tab4.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab4.label_1') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.insurance",
            'value'    => array_get($passwork->data, 'insurance'),
            'values'   => [1 => __('sogetrel.user.passwork._tab4.yes'), 0 => __('sogetrel.user.passwork._tab4.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab4.label_2') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.availability",
            'value'    => array_get($passwork->data, 'availability'),
            'values'   => [
                'half_a_day' => __('sogetrel.user.passwork._tab4.half_a_day'),
                '1_day'      => __('sogetrel.user.passwork._tab4.1_day'),
                '2_days'     => __('sogetrel.user.passwork._tab4.2_days'),
                '3_days'     => __('sogetrel.user.passwork._tab4.3_days'),
                '4_days'     => __('sogetrel.user.passwork._tab4.4_days'),
                '5_days'     => __('sogetrel.user.passwork._tab4.5_days'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab4.label_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.acquisition",
            'value'    => array_get($passwork->data, 'acquisition'),
            'id'       => 'acquisition',
            'values'   => [
                'email'                   => __('sogetrel.user.passwork._tab4.email'),
                'call_email'              => __('sogetrel.user.passwork._tab4.call_email'),
                'facebook_ad'             => __('sogetrel.user.passwork._tab4.facebook_ad'),
                'google_ad'               => __('sogetrel.user.passwork._tab4.google_ad'),
                'freelance_federation_ad' => __('sogetrel.user.passwork._tab4.freelance_federation_ad'),
                'pole_emploi'             => __('sogetrel.user.passwork._tab4.pole_emploi'),
                'sogetrel'                => __('sogetrel.user.passwork._tab4.sogetrel'),
                'leboncoin_ad'            => __('sogetrel.user.passwork._tab4.leboncoin_ad'),
                'other'                   => __('sogetrel.user.passwork._tab4.other'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab4.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6" data-shown-if="#acquisition:other">
        @component('components.form.group', [
            'type'     => "text",
            'name'     => "passwork.data.acquisition_other",
            'value'    => array_get($passwork->data, 'acquisition_other'),
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab4.label_5') }}
            @endslot
        @endcomponent
    </div>
</div>
