<button class="btn btn-outline-secondary"
    type="button"
    data-toggle="collapse"
    data-target="#collapseFilters"
    aria-expanded="false"
    aria-controls="collapseFilters"
>
    <span>@icon('filter') {{ __('enterprise.resource.application.views._filter.filter') }}</span>
</button>

<div class="collapse my-3 @if(request()->has('filter')) show @endif" role="filter" id="collapseFilters">
    <div class="row">
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.number'),
                'type'  => "text",
                'name'  => "filter[number]",
                'value' => request()->input('filter.number')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.last_name'),
                'type'  => "text",
                'name'  => "filter[last_name]",
                'value' => request()->input('filter.last_name')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.first_name'),
                'type'  => "text",
                'name'  => "filter[first_name]",
                'value' => request()->input('filter.first_name')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.email'),
                'type'  => "text",
                'name'  => "filter[email]",
                'value' => request()->input('filter.email')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.registration_number'),
                'type'  => "text",
                'name'  => "filter[registration_number]",
                'value' => request()->input('filter.registration_number')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text' => __('enterprise.resource.application.views._filter.status'),
                'type'    => "select",
                'name'    => "filter[status]",
                'options' => Repository::resource()->getAvailableStatuses(),
                'value'   => request()->input('filter.status')
            ])
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-outline-primary rounded">@icon('check') {{ __('enterprise.resource.application.views._filter.filters') }}</button>

        @if(array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger ml-2 rounded">@icon('times') {{ __('enterprise.resource.application.views._filter.reset') }}</a>
        @endif
    </div>
</div>
