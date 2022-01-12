<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.electrician',
            'value'    => array_get($passwork->data, 'electrician'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "electrician",
            'required' => true,
        ])

            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._tab1.help_1') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.multi_activities',
            'value'    => array_get($passwork->data, 'multi_activities'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "technician",
            'required' => true,
        ])

            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_2') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._tab1.help_2') }}
            @endslot
        @endcomponent

       @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.cavi',
            'value'    => array_get($passwork->data, 'cavi'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "technicien_cavi",
            'required' => true,
        ])

            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_15') }}
            @endslot    
            @slot('help')
                {{ __('sogetrel.user.passwork._tab1.help_3') }}
            @endslot

        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.engineering_computer_mib',
            'value'    => array_get($passwork->data, 'engineering_computer_mib'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "engineering_computer",
            'required' => true,
        ])

            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_16') }}
            @endslot
            @slot('help')
                {{ __('sogetrel.user.passwork._tab1.help_4') }}
            @endslot

        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.engineering_office',
            'value'    => array_get($passwork->data, 'engineering_office'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "engineering_office",
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_3') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.civil_engineering',
            'value'    => array_get($passwork->data, 'civil_engineering'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "civil_engineering",
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_4') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => 'passwork.data.years_of_experience',
            'value'    => array_get($passwork->data, 'years_of_experience'),
            'required' => true,
            'values'   => [
                'less_than_1'      => __('sogetrel.user.passwork._tab1.less_than_1'),
                'between_1_and_3'  => __('sogetrel.user.passwork._tab1.between_1_and_3'),
                'between_3_and_10' => __('sogetrel.user.passwork._tab1.between_3_and_10'),
                'more_than_10'     => __('sogetrel.user.passwork._tab1.more_than_10')
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_5') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.independant",
            'value'    => array_get($passwork->data, 'independant'),
            'values'   => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'id'       => "independant",
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_6') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'type'     => "text",
            'name'     => "passwork.data.phone",
            'value'    => array_get($passwork->data, 'phone'),
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_7') }}
            @endslot

            @slot('placeholder')
                00 00 00 00 00
            @endslot
        @endcomponent

    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "checkbox_list",
            'name'     => "departments.",
            'value'    => $passwork->departments->pluck('id')->toArray(),
            'values'   => department()::options(),
            'height'   => '30em',
            'required' => true,
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_8') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'    => "select",
            'name'    => "passwork.data.wants_to_be_independant",
            'value'   => array_get($passwork->data, 'wants_to_be_independant'),
            'values'  => [1 => __('sogetrel.user.passwork._tab1.yes'), 0 => __('sogetrel.user.passwork._tab1.no')],
            'shownif' => '#independant:0',
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_9') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'    => "text",
            'name'    => "passwork.data.enterprise_name",
            'value'   => array_get($passwork->data, 'enterprise_name'),
            'shownif' => '#independant:1'
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_10') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "number",
            'name'     => "passwork.data.enterprise_postal_code",
            'value'    => array_get($passwork->data, 'enterprise_postal_code'),
            'required' => true,
            'shownif' => '#independant:1'
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_11') }}
            @endslot

            @slot('placeholder')
                75009
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'    => "number",
            'step'    => 1,
            'min'     => 0,
            'name'    => "passwork.data.enterprise_number_of_employees",
            'value'   => array_get($passwork->data, 'enterprise_number_of_employees'),
            'shownif' => '#independant:1'
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_12') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'    => "select",
            'name'    => 'passwork.data.years_of_experience_as_independant',
            'value'   => array_get($passwork->data, 'years_of_experience_as_independant'),
            'shownif' => '#independant:1',
            'values'  => [
                'less_than_1'     => __('sogetrel.user.passwork._tab1.less_than_1'),
                'between_1_and_3' => __('sogetrel.user.passwork._tab1.between_1_and_3'),
                'more_than_3'     => __('sogetrel.user.passwork._tab1.more_than_3')
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.label_13') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.form.group', [
            'type'    => "text",
            'name'    => 'passwork.data.website',
            'value'   => array_get($passwork->data, 'website'),
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._tab1.site_web') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @form_group([
            'type'        => "file",
            'name'        => "file.content",
            'text'        => __('sogetrel.user.passwork._tab1.label_14'),
            'accept'      => 'application/pdf',
            'required'    => false,
        ])
    </div>
</div>
