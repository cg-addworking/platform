<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>@money($total_amount_before_taxes)</h2>
                <span>{{ __('addworking.components.billing.inbound.index.card.amount_before_taxes') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h2>@money($total_amount_of_taxes)</h2>
                <span>{{ __('addworking.components.billing.inbound.index.card.amount_of_taxes') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>@money($total_amount_all_taxes_included)</h2>
                <span>{{ __('addworking.components.billing.inbound.index.card.amount_all_taxes_included') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $number_total_of_invoices }}</h2>
                <span>{{ __('addworking.components.billing.inbound.index.card.number_total_of_invoices') }}</span>
            </div>
        </div>
    </div>
</div>