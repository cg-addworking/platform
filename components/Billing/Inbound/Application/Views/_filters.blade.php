<div class="row" role="filter">
    @if (auth()->user()->enterprises->count() > 1)
        <div class="col-md-3">
            @form_group([
                'text'     => __('addworking.components.billing.inbound.index.filters.customer'),
                'type'     => "select",
                'name'     => "filter.customers.",
                'options'  => auth()->user()->enterprises->pluck('name', 'name'),
                'value'    => request()->input('filter.customers'),
                'multiple' => true,
                'selectpicker' => true,
            ])
        </div>
    @endif
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.components.billing.inbound.index.filters.vendor'),
            'type'     => "select",
            'name'     => "filter.vendors.",
            'options'  =>  $vendors,
            'value'    => request()->input('filter.vendors'),
            'multiple' => true,
            'selectpicker' => true,
            'search' => true,
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.components.billing.inbound.index.filters.month'),
            'type'     => "select",
            'name'     => "filter.months.",
            'options'  => inbound_invoice()::getAvailableMonths(),
            'value'    => request()->input('filter.months'),
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('addworking.components.billing.inbound.index.filters.status'),
            'type'     => "select",
            'name'     => "filter.status.",
            'options'  => array_trans(array_mirror(inbound_invoice()::getAvailableStatuses()),
                'addworking.components.billing.inbound.index.filters.'),
            'value'    => request()->input('filter.status'),
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>
    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('addworking.components.billing.inbound.index.filters.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('addworking.components.billing.inbound.index.filters.reset') }}</a>
        @endif
    </div>
</div>