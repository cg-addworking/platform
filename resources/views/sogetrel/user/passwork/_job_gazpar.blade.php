<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_gazpar.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.gazpar.trained",
            'value'    => array_get($passwork->data, 'gazpar.trained'),
            'values'   => [
                'yes'              => __('sogetrel.user.passwork._job_gazpar.yes'),
                'no'               => __('sogetrel.user.passwork._job_gazpar.no'),
                'willing_to_learn' => __('sogetrel.user.passwork._job_gazpar.willing_to_learn'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_gazpar.label') }}
            @endslot
        @endcomponent
    </div>
</div>
