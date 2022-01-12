<div class="row">
    <div class="col-md-8">
        @attribute("{$inbound_invoice_item->label}|icon:tag|label: ".__('addworking.billing.inbound_invoice_item._html.wording'))
        @attribute("{$inbound_invoice_item->quantity}|icon:calendar-alt|label: ".__('addworking.billing.inbound_invoice_item._html.amount'))

        @component('bootstrap::attribute', ['label' =>  __('addworking.billing.inbound_invoice_item._html.unit_price'), 'icon' => "credit-card"])
            {{ $inbound_invoice_item->unit_price ." €"}}
        @endcomponent

        @component('bootstrap::attribute', ['label' =>  __('addworking.billing.inbound_invoice_item._html.amount_before_taxes'), 'icon' => "credit-card"])
            @money($inbound_invoice_item->getAmountBeforeTaxes())
        @endcomponent

        @attribute("{$inbound_invoice_item->vatRate->display_name}|icon:percent|label:Taux TVA")

        @component('bootstrap::attribute', ['label' =>  __('addworking.billing.inbound_invoice_item._html.tax_amount'), 'icon' => "credit-card"])
            @money($inbound_invoice_item->getAmountOfTaxes())
        @endcomponent

        @component('bootstrap::attribute', ['label' =>  __('addworking.billing.inbound_invoice_item._html.amount_all_taxes_included'), 'icon' => "credit-card"])
            @money($inbound_invoice_item->getAmountAllTaxesIncluded())
        @endcomponent
    </div>
    <div class="col-md-4">
        @attribute("{$inbound_invoice_item->id}|icon:id-card-alt|label: ".__('addworking.billing.inbound_invoice_item._html.username'))
        @attribute("{$inbound_invoice_item->created_at}|icon:calendar-plus|label: ".__('addworking.billing.inbound_invoice_item._html.created_date'))
        @attribute("{$inbound_invoice_item->updated_at}|icon:calendar-check|label: ".__('addworking.billing.inbound_invoice_item._html.last_modified_date'))
    </div>
</div>
