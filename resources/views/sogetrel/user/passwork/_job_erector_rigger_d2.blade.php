<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_erector_rigger_d2.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.erector_rigger_d2.level",
            'value'  => array_get($passwork->data, 'erector_rigger_d2.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_erector_rigger_d2.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_erector_rigger_d2.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_erector_rigger_d2.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_erector_rigger_d2.label') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_erector_rigger_d2.help_1') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_d2.help_2') }}
                {{ __('sogetrel.user.passwork._job_erector_rigger_d2.help_3') }}
            @endslot
        @endcomponent
    </div>
</div>

