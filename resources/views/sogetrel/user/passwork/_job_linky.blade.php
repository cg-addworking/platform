<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_linky.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.linky.trained",
            'value'    => array_get($passwork->data, 'linky.trained'),
            'values'   => [
                1                  => __('sogetrel.user.passwork._job_linky.yes'),
                0                  => __('sogetrel.user.passwork._job_linky.no'),
                'willing_to_learn' => __('sogetrel.user.passwork._job_linky.willing_to_learn'),
            ],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_linky.label_1') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.linky.level",
            'value'    => array_get($passwork->data, 'linky.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_linky.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_linky.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_linky.expert'),
            ],
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_linky.label_2') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_linky.help_1') }}
                {{ __('sogetrel.user.passwork._job_linky.help_2') }}
                {{ __('sogetrel.user.passwork._job_linky.help_3') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.linky.deposit",
            'value'    => array_get($passwork->data, 'linky.deposit'),
            'values'   => [1 => __('sogetrel.user.passwork._job_linky.yes'), 0 => __('sogetrel.user.passwork._job_linky.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_linky.label_3') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.linky.programming",
            'value'    => array_get($passwork->data, 'linky.programming'),
            'values'   => [1 => __('sogetrel.user.passwork._job_linky.yes'), 0 => __('sogetrel.user.passwork._job_linky.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_linky.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.linky.maintenance",
            'value'    => array_get($passwork->data, 'linky.maintenance'),
            'values'   => [1 => __('sogetrel.user.passwork._job_linky.yes'), 0 => __('sogetrel.user.passwork._job_linky.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_linky.label_5') }}
            @endslot
        @endcomponent
    </div>
</div>
