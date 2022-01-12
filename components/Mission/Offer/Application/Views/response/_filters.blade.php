<div class="row" role="filter">
    <div class="col-md-12">
        @form_group([
            'text'     => __('offer::response._filters.status'),
            'type'     => "select",
            'name'     => "filter.status.",
            'options'  => $statuses,
            'value'    => request()->input('filter.status'),
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>
    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('offer::response._filters.submit') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('offer::response._filters.reset') }}</a>
        @endif
    </div>
</div>
