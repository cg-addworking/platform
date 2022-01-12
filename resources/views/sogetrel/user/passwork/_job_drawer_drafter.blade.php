<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_drawer_drafter.designer') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.drawer_drafter.years_of_experience",
            'value'    => array_get($passwork->data, 'drawer_drafter.years_of_experience'),
            'values'   => [
                'less_than_1'     => __('sogetrel.user.passwork._job_drawer_drafter.less_than_1'),
                'between_1_and_3' => __('sogetrel.user.passwork._job_drawer_drafter.between_1_and_3'),
                'more_than_3'     => __('sogetrel.user.passwork._job_drawer_drafter.more_than_3')
            ],
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_drawer_drafter.label') }}
            @endslot
        @endcomponent
    </div>
</div>
