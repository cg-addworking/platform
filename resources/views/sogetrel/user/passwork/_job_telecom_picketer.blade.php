<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_telecom_picketer.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.telecom_picketer.years_of_experience",
            'value'    => array_get($passwork->data, 'telecom_picketer.years_of_experience'),
            'values'   => [
                'less_than_1'     => __('sogetrel.user.passwork._job_telecom_picketer.less_than_1'),
                'between_1_and_3' => __('sogetrel.user.passwork._job_telecom_picketer.between_1_and_3'),
                'more_than_3'     => __('sogetrel.user.passwork._job_telecom_picketer.more_than_3')
            ],
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_telecom_picketer.label') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "passwork.data.telecom_picketer.other_experience.",
            'value'    => array_keys(array_get($passwork->data, 'telecom_picketer.other_experience', [])),
            'values'   => [
                'aerial'        => __('sogetrel.user.passwork._job_telecom_picketer.aerial'),
                'subterranean'  => __('sogetrel.user.passwork._job_telecom_picketer.subterranean'),
                'building'      => __('sogetrel.user.passwork._job_telecom_picketer.building'),
                'pavillonnaire' => __('sogetrel.user.passwork._job_telecom_picketer.pavillonnaire'),
            ]
        ])
        @endcomponent
    </div>
</div>
