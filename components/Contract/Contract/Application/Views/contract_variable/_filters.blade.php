<div class="row" role="filter">
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_variable._filters.model_variable_display_name'),
            'type'     => "text",
            'name'     => "filter.model_variable_display_name",
            'value'    => request()->input('filter.model_variable_display_name'),
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_variable._filters.model_variable_model_part_display_name'),
            'type'     => "text",
            'name'     => "filter.model_variable_model_part_display_name",
            'value'    => request()->input('filter.model_variable_model_part_display_name'),
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_variable._filters.model_variable_required'),
            'type'     => "select",
            'options'  => ['false' => "Non", 'true' => "Oui"],
            'name'     => "filter.model_variable_required",
            'value'  => request()->input('filter.model_variable_required'),
        ])
    </div>

    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('components.contract.contract.application.views.contract_variable._filters.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])) or request()->input('search'))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('components.contract.contract.application.views.contract_variable._filters.reset') }}</a>
        @endif
    </div>
</div>