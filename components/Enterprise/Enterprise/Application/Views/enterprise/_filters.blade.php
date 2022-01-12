<div class="row" role="filter">
    <div class="col-md-3">
        <label>{{ __('addworking.enterprise.enterprise.index.filter.type') }}</label>
        <select class="form-control" name="filter[type]">
            <option></option>
            <option value="vendor" @if(request()->input('filter.type') == 'vendor') selected @endif>{{ __('addworking.enterprise.enterprise.index.vendor') }}</option>
            <option value="customer" @if(request()->input('filter.type') == 'customer') selected @endif>{{__('addworking.enterprise.enterprise.index.customer') }}</option>
            <option value="customer+vendor" @if(request()->input('filter.type') == 'customer+vendor') selected @endif>{{__('addworking.enterprise.enterprise.index.hybrid') }}</option>
        </select>
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.enterprise.enterprise.index.filter.legal_form'),
            'type'     => "select",
            'name'     => "filter.legal_form",
            'options'  => legal_form([])->pluck('display_name', 'id')->unique(),
            'value'    => request()->input('filter.legal_form')
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.enterprise.enterprise.index.filter.activity_field'),
            'type'     => "select",
            'name'     => "filter.activity_field",
            'options'  => enterprise_activity([])->getAvailableFields(),
            'value'    => request()->input('filter.activity_field'),
            'search'   => true,
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.enterprise.enterprise.index.filter.activity'),
            'type'     => "text",
            'name'     => "filter.activity",
            'value'    => request()->input('filter.activity'),
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.enterprise.enterprise.index.filter.main_activity_code'),
            'type'     => "text",
            'name'     => "filter.main_activity_code",
            'value'    => request()->input('filter.main_activity_code'),
        ])
    </div>
    <div class="col-12 text-right">
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-3 rounded">@icon('times') {{__('addworking.enterprise.enterprise.index.filter.reinitialize')}}</a>
        @endif
    </div>
</div>