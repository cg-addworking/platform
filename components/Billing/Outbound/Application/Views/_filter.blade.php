@inject('outbound', 'Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository')
@inject('deadline', 'Components\Billing\Outbound\Application\Repositories\DeadlineRepository')

<button class="btn btn-outline-secondary btn-block mb-2" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
    <span>@icon('filter') {{ __('billing.outbound.application.views._filter.filter') }}</span>
</button>
<div class="row col-md-12 collapse" role="filter" id="collapseFilters">
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.bill_number') }}</label>
        @form_control([
            'type'  => "text",
            'name'  => "filter[number]",
            'value' => request()->input('filter.number')
        ])
    </div>
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.due_date') }}</label>
        @form_control([
            'type'  => "date",
            'name'  => "filter[due_at]",
            'value' => request()->input('filter.due_at')
        ])
    </div>
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.invoice_date') }}</label>
        @form_control([
            'type'  => "date",
            'name'  => "filter[invoiced_at]",
            'value' => request()->input('filter.invoiced_at')
        ])
    </div>
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.billing_period') }}</label>
        @form_control([
            'type'    => "select",
            'name'    => "filter[month]",
            'options' => $outbound->getPeriods(),
            'value'   => request()->input('filter.month')
        ])
    </div>
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.payment_deadline') }}</label>
        @form_control([
            'type'    => "select",
            'name'    => "filter[deadline]",
            'options' => $deadline->getDeadlines(),
            'value'   => request()->input('filter.deadline')
        ])
    </div>
    <div class="col-md-4 mb-2">
        <label>{{ __('billing.outbound.application.views._filter.status') }}</label>
        @form_control([
            'type'    => "select",
            'name'    => "filter[status]",
            'options' => array_trans(array_mirror($outbound->getStatuses()), 'billing.outbound.application.views._status.'),
            'value'   => request()->input('filter.status')
        ])
    </div>
    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('billing.outbound.application.views._filter.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('billing.outbound.application.views._filter.reset') }}</a>
        @endif
    </div>
</div>