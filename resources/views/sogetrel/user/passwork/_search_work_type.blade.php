<div class="row">
        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'name'   => "search.electrician",
                'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                'value'  => request()->input('search.electrician'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search_work_type.electrician') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'name'   => "search.multi_activities",
                'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                'value'  => request()->input('search.multi_activities')
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search_work_type.label_1') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-2">
                @component('components.form.group', [
                    'type'   => "select",
                    'name'   => "search.engineering_computer",
                    'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                    'value'  => request()->input('search.engineering_computer')
                ])
                        @slot('label')
                             {{ __('sogetrel.user.passwork._search_work_type.engineering_computer') }}
                        @endslot
                @endcomponent
        </div>

        <div class="col-md-2">
                @component('components.form.group', [
                    'type'   => "select",
                    'name'   => "search.technicien_cavi",
                    'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                    'value'  => request()->input('search.technicien_cavi')
                ])
                        @slot('label')
                                {{ __('sogetrel.user.passwork._search_work_type.technicien_cavi') }}
                        @endslot
                @endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'name'   => "search.civil_engineering",
                'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                'value'  => request()->input('search.civil_engineering'),
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search_work_type.civil_engineering') }}
                @endslot
            @endcomponent
        </div>

        <div class="col-md-2">
            @component('components.form.group', [
                'type'   => "select",
                'name'   => "search.engineering_office",
                'values' => [1 => __('sogetrel.user.passwork._search_work_type.yes'), 0 => __('sogetrel.user.passwork._search_work_type.no')],
                'value'  => request()->input('search.engineering_office')
            ])
                @slot('label')
                    {{ __('sogetrel.user.passwork._search_work_type.label_2') }}
                @endslot
            @endcomponent
        </div>
    </div>
