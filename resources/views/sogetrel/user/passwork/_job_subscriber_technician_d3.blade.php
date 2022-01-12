<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_subscriber_technician_d3.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.subscriber_technician_d3.level",
            'value'  => array_get($passwork->data, 'subscriber_technician_d3.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_subscriber_technician_d3.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_subscriber_technician_d3.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_subscriber_technician_d3.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_subscriber_technician_d3.label') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_subscriber_technician_d3.help_1') }}
                {{ __('sogetrel.user.passwork._job_subscriber_technician_d3.help_2') }}
                {{ __('sogetrel.user.passwork._job_subscriber_technician_d3.help_3') }}
            @endslot
        @endcomponent
    </div>
</div>
